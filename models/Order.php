<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/24
 * Time: 16:08
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    /***
     * 从有赞 获取订单数据
     */
    public function AddOrder($order)
    {

        var_dump($order)."<br />";die;
        self::tableName();
        $this->order_sn = $order['tid'];
        $this->order_status = $order['status'];
        $this->refund_state = $order['refund_state'];
        $this->consignee = $order['receiver_name'];
        $this->province = $order['receiver_state'];
        $this->city = $order['receiver_city'];
        $this->district = $order['receiver_district'];
        $this->address = $order['receiver_address'];
        $this->mobile = $order['receiver_mobile'];
        $this->shipping_type = $order['shipping_type'];
        $this->goods_amount = $order['price'];
        $this->post_fee = $order['post_fee'];
        $this->pay_fee = $order['payment'];
        $this->refunded_fee = $order['refunded_fee'];
        $this->order_amount = $order['total_fee'];
        $this->created = $order['created'];
        $this->sign_time = $order['sign_time'];
        $this->pay_time = $order['pay_time'];
        $this->consign_time = $order['consign_time'];
        $this->data = json_encode($order);


        //  var_dump($user);die;
        //order_info表插入数据库
        $order_id = self::save() ? Yii::$app->db->lastInsertID : '';
        if (!$order_id) {
            //Yii::getLogger()->log($msg, $level, $category)
            Yii::getLogger()->log("有赞订单：{$order['tid']}没有创建成功");
            return false;
        }
        //order_goods表
        $order_goods = new OrderGoods();
        foreach ($order['orders'] as $param) {
            $param['order_sn'] = $order['tid'];
            $param['order_id'] = $order_id;
            $rec_id = $order_goods->AddOrderGoods($param);
            //$rec_id = 1;
            if (!$rec_id) {
                Yii::getLogger()->log("有赞订单：{$order['tid']},系统订单id{$order_id}没有创建成功order_goods");
                break;
            }
            //1.判断是不是课程：如果是就继续，如果不是课程，就执行完成；
            $code = $param['outer_item_id'];
            // $code = 'ZC160006';
            //$sql = "SELECT course_id FROM `course` WHERE `code` = '".$code."'";
            $sql = "SELECT c.course_id,s.section_id,s.expire_time 
                    FROM `course_section` as cs
                    LEFT JOIN `course` as c ON cs.course_id = c.course_id
                    LEFT JOIN `section` as s ON cs.section_id = s.section_id 
                    WHERE c.code = '{$code}'";
            $courses = Yii::$app->db->createCommand($sql)->queryAll();
            if (!$courses) {
                Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                break;
            }
            foreach ($courses as $course) {
                $expire_time = date('Y-m-d H:i:s', strtotime($course['expire_time']) + 86400 * 30 * 3);
                //print_r($course);die;
                if (!$course['course_id']) {
                    Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                    break;
                }
                //$order['receiver_mobile'] = '18636342640';
                //3.查看订单手机号是否在用户表存在
                $user_id = User::getUserByName($order['receiver_mobile']);
                $course_id = $course['course_id'];
                if ($user_id) {
                    //4.检查该用户是否已经上过该课程的阶段
                    $sql = "select max(cs.sort) as sort from `section` as cs left join `user_course` as uc on cs.section_id = uc.section_id WHERE uc.course_id = '{$course_id}' and uc.user_id = '{$user_id}'";
                    //echo $sql;die;
                    $user_max_sort = Yii::$app->db->createCommand($sql)->queryOne();
                    //print_r($user_max_sort);die; ok
                    if ($user_max_sort['sort']) {
                        //上过该课程，需要创建新的阶段课程
                        $sql = "select min(s.sort) as sort from `section` as s 
                                left join `course_section` as cs on s.section_id = cs.section_id 
                                WHERE cs.course_id = '{$course_id}' and s.sort>'{$user_max_sort['sort']}'";
                        //echo $sql;die;
                        $user_next_section = Yii::$app->db->createCommand($sql)->queryOne();
                        //没有最新阶段
                        if (!$user_next_section['sort']) {
                            break;
                        }
                        //print_r($user_next_section);die;
                        $sql = "select min(s.*) from `section` as s 
                                left join `course_section` as cs on s.section_id = cs.section_id 
                                WHERE cs.course_id = '{$course_id}' and s.sort>'{$user_next_section['sort']}'";
                        $new_section = Yii::$app->db->createCommand($sql)->queryOne();
                        $expire_time = date('Y-m-d H:i:s', strtotime($new_section['expire_time']) + 86400 * 30 * 3);
                        $user_course = array(
                            'course_id' => $new_section['course_id'],
                            'section_id' => $new_section['section_id'],
                            'version' => 1,
                            'user_id' => $user_id,
                            'create_time' => date('Y-m-d H:i:s'),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => $expire_time,
                        );
                    } else {
                        //没有上过，创建记录
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'version' => 1,
                            'user_id' => $user_id,
                            'create_time' => date('Y-m-d H:i:s'),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => $expire_time,
                        );

                    }
                    //用户存在插入新的课程和用户的关系
                    $usercourse = new UserCourse();
                    $id = $usercourse->add($user_course);
                    //echo $id;die;  ok
                    return $id;
                } else {
                    //用户不存在，创建用户，建立用户关系
                    $user = array('phone' => $order['receiver_mobile'], 'password' => '');
                    $users = new User();
                    $new_user_id = $users->Signup($user);
                    if ($new_user_id) {
                        //会员添加成功
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'version' => 1,
                            'user_id' => $new_user_id,
                            'create_time' => date('Y-m-d H:i:s'),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => $expire_time,
                        );
                        $usercourse = new UserCourse();
                        $id = $usercourse->add($user_course);
                        return $id;
                    }
                }
            }
        }
    }

    public static function tableName()
    {
        return 'order_info';
    }


}