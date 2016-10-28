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
    public function AddOrder($order){

        //var_dump($order);die;
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
        $this->data =json_encode($order);


        //  var_dump($user);die;
        //order_info表插入数据库
        //$order_id  = self::save() ? Yii::$app->db->lastInsertID : '';
        $order_id =1;
        if($order_id){
            //order_goods表
            $order_goods = new OrderGoods();
            foreach ($order['orders'] as $param){
                $param['order_sn'] = $order['tid'];
                $param['order_id'] = $order_id;
                //$rec_id = $order_goods ->AddOrderGoods($param);
                $rec_id = 1;
                if ($rec_id){
                    //1.判断是不是课程：如果是就继续，如果不是课程，就执行完成；
                   $code = $param['outer_item_id'];
                    //$sql = "SELECT course_id FROM `course` WHERE `code` = '".$code."'";
                    $sql = "SELECT c.course_id,s.section_id,s.expire_time FROM `course` as c left join `course_section` as s on c.course_id = s.course_id WHERE c.code = '{$code}'";
                    $course = Yii::$app->db->createCommand($sql)->queryOne();
                    //print_r($course);die;
                    if($course['course_id']){
                        //2.判断订单是否已经完结，完结就创建关系，没有完结就不创建用户关系

                        //3.查看订单手机号是否在用户表存在
                        $user_id = User::getUserByName($order['receiver_mobile']);
                        $course_id = $course['course_id'];
                        if($user_id){
                            //4.检查该用户是否已经上过该课程的阶段
                            $sql = "select cs.section_id,cs.sort from `course_section` as cs left join `user_course` as uc on cs.section_id = uc.section_id WHERE uc.course_id = '{$course_id}' and uc.user_id = '{$user_id}'";
                            //echo $sql;die;
                            $user_section = Yii::$app->db->createCommand($sql)->queryAll();
                            if($user_section){
                                //上过该课程，需要创建新的阶段课程
                                $sort = $user_section['sort']+1;
                                $sql = "select * from course_section where sort = '{$sort}' and course_id = '{$course['course_id']}'";
                                $new_section = Yii::$app->db->createCommand($sql)->queryOne();
                                $user_course = array(
                                    'course_id' => $new_section['course_id'],
                                    'section_id' => $new_section['section_id'],
                                    'version' => 1,
                                    'user_id' => $user_id,
                                    'create_time' => date('Y-m-d H:i:s'),
                                    'expire_time' =>$new_section['expire_time'],
                                );


                            }else{
                                //没有上过，创建记录
                                $user_course = array(
                                    'course_id' => $course['course_id'],
                                    'section_id' => $course['section_id'],
                                    'version' => 1,
                                    'user_id' => $user_id,
                                    'create_time' => date('Y-m-d H:i:s'),
                                    'expire_time' =>$course['expire_time'],
                                );

                            }
                           //用户存在插入新的课程和用户的关系
                            $usercourse = new UserCourse();
                            $id = $usercourse->add($user_course);
                            return $id;
                        }else{
                            //用户不存在，创建用户，建立用户关系
                            $user = array('phone'=>$order['receiver_mobile'],'password'=>'' );
                            $users = new User();
                            $result = $user->signup($user);
                            return  $result;
                        }

                    }else{
                        break;
                    }

                }else{
                    //order_goods 没有插入成功，order_info 这个表如何设置
                }
            }

        }



        return ;

    }
    public static function tableName()
    {
        return 'order_info';
    }


}