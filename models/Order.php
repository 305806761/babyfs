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
use yii\data\Pagination;

class Order extends ActiveRecord
{
    /***
     * 从有赞 获取订单数据
     */
    public function AddOrder($order)
    {
        Yii::warning(json_encode($order));
        $this->order_sn = trim($order['tid']);
        $this->order_status = $order['status'] ? $order['status'] : 'WAIT_SELLER_SEND_GOODS';
        $this->refund_state = $order['refund_state'] ? $order['refund_state'] : 'NO_REFUND';
        $this->consignee = $order['receiver_name'];
        $this->province = $order['receiver_state'];
        $this->city = $order['receiver_city'];
        $this->district = $order['receiver_district'];
        $this->address = $order['receiver_address'];
        $this->mobile = trim($order['receiver_mobile']);
        $this->shipping_type = $order['shipping_type'] ? $order['shipping_type'] : 'express';
        $this->goods_amount = $order['price'] ? $order['price'] : '0.00';
        $this->post_fee = $order['post_fee'] ? $order['post_fee'] : '0.00';
        $this->pay_fee = $order['payment'] ? $order['payment'] : '0.00';
        $this->refunded_fee = $order['refunded_fee'] ? $order['refunded_fee'] : '0.00';
        $this->order_amount = $order['total_fee'] ? $order['total_fee'] : '0.00';
        $this->created = $order['created'] ? $order['created'] : date('Y-m-d H:i:s');
        $this->sign_time = $order['sign_time'] ? $order['sign_time'] : date('Y-m-d H:i:s');
        $this->pay_time = $order['pay_time'] ? $order['pay_time'] : date('Y-m-d H:i:s');
        $this->consign_time = $order['consign_time'] ? $order['consign_time'] : date('Y-m-d H:i:s');
        $this->data = json_encode($order);

        //订单已经存在
        if (!$this->order_sn ) {
            return false;
       }
        //订单已经存在
        if (Order::findOne(['order_sn' => trim($this->order_sn)])) {
            return false;
       }

        //$order_id = 8;
        $order_id = $this->save() ? Yii::$app->db->lastInsertID : '';
        Yii::warning(json_encode($order_id.'order_id存在'));
        if (!$order_id) {
            Yii::warning(json_encode($this->errors));
            return false;
        }

        foreach ($order['orders'] as $key => $param) {
            $order_goods = new OrderGoods();
            $param['order_sn'] = $this->order_sn;
            $param['order_id'] = $order_id;
            $rec_id = $order_goods->AddOrderGoods($param);
            //$rec_id = 7;
            if (!$rec_id) {
                Yii::warning(json_encode($this->errors));
                continue;
                //break;
            }
            Yii::warning(json_encode($rec_id.'rec_id存在'));
            //1.判断是不是课程：如果是就继续，如果不是课程，就执行完成；
            $code = trim($param['outer_item_id']);
             //$code = 'KY160001';
            //$sql = "SELECT course_id FROM `course` WHERE `code` = '".$code."'";
            $sql = "SELECT cs.course_id,cs.section_id,c.type
                    FROM `course_section` as cs
                    LEFT JOIN `course` as c ON cs.course_id = c.course_id
                    WHERE c.code = '{$code}' AND c.type in (1,3)";//and s.sort=1
            $courses = Yii::$app->db->createCommand($sql)->queryAll();
            if (!$courses) {
                Yii::warning(json_encode($this->errors));
                continue;
                //break;
            }
            Yii::warning(json_encode($courses.'课程存在'));
            //print_r($courses);die;
            foreach ($courses as $course) {
               // $expire_time = date('Y-m-d H:i:s', strtotime($course['expire_time']) + 86400 * 30 * 3);
                Yii::warning(json_encode($this->errors));
                if (!$course['course_id']) {
                    //Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                    continue;
                    //break;
                }
                //如果是免费课，不管购买几次，都只添加一次权限
                $usfree = UserCourse::find()->from(['uc' => UserCourse::tableName()])->select('id')
                    ->joinWith('section')
                    ->where([
                        'AND',
                        ['in','code',['KY160030','KC160031','KC160032']],
                        ['=','uc.section_id',$course['section_id']],
                    ])->count();
                if($usfree){
                    //Yii::info($usfree,'test');
                    continue;
                }
                //判断是阶段的那个学期
                $term = TermModel::find()->where(
                    [
                        'AND',['=','status',2],
                        ['=','section_id',$course['section_id']],
                        ['>=','order_end_time',strtotime($this->created)],
                        ['<=','order_start_time',strtotime($this->created)],
                        //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
                    ]
                )->asArray()->one();
                if (!$term) {
                    //Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                    continue;
                    //break;
                }
                if($course['type'] == 3){
                    $term['start_time'] = time();
                    $term['end_time'] = Yii::$app->params['course_expire'];
                }
                Yii::warning(json_encode($term.'阶段学期存在'));
                //$order['receiver_mobile'] = '18636342640';
                //3.查看订单手机号是否在用户表存在  $user 是对象
                $user = User::getUserByName($this->mobile);
                $course_id = $course['course_id'];
                if ($user->user_id) {
                    $user_id = $user->user_id;
                    Order::updateAll(['user_id' => $user_id], "order_id = $order_id");
                    //4.检查该用户是否已经上过该课程的阶段
//                    $sql = "select max(cs.sort) as sort from `section` as cs left join `user_course` as uc on cs.section_id = uc.section_id WHERE uc.course_id = '{$course_id}' and uc.user_id = '{$user_id}'";
//                    //echo $sql;die;
//                    $user_max_sort = Yii::$app->db->createCommand($sql)->queryOne();
//                    //print_r($user_max_sort);die;
//                    if ($user_max_sort['sort']) {
//                        //上过该课程，需要创建新的阶段课程
//                        $sql = "select min(s.sort) as sort from `section` as s
//                                left join `course_section` as cs on s.section_id = cs.section_id
//                                WHERE cs.course_id = '{$course_id}' and s.sort>'{$user_max_sort['sort']}'";
//                        //echo $sql;die;
//                        $user_next_section = Yii::$app->db->createCommand($sql)->queryOne();
//                        //没有最新阶段
//                        if (!$user_next_section['sort']) {
//                            continue;
//                            //break;
//                        }
//                        //print_r($user_next_section);die;
//                        $sql = "select s.* from `section` as s
//                                left join `course_section` as cs on s.section_id = cs.section_id
//                                WHERE cs.course_id = '{$course_id}' and s.sort='{$user_next_section['sort']}'";
//                        //echo $sql;die;
//                        $new_section = Yii::$app->db->createCommand($sql)->queryOne();
//
//                        //判断用户是该阶段下的那个学期
//                        //order_start_time<=$this->created<=order_end_time
//                        $new_term = TermModel::find()->where(
//                            [
//                                'AND',['=','status',2],
//                                ['=','section_id',$new_section['section_id']],
//                                ['>=','order_end_time',strtotime($this->created)],
//                                ['<=','order_start_time',strtotime($this->created)],
//                                //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
//                            ]
//                        )->asArray()->one();
//                        if($course['type'] == 3){
//                            $new_term['start_time'] = time();
//                            $new_term['end_time'] = Yii::$app->params['course_expire'];
//                        }
//
//                        //print_r($term);die;
//                        //$expire_time = date('Y-m-d H:i:s', strtotime($new_section['expire_time']) + 86400 * 30 * 3);
//                        $user_course = array(
//                            'course_id' => $new_section['course_id'],
//                            'section_id' => $new_section['section_id'],
//                            'term_id' => $new_term['id'],
//                            'started' => 2,
//                            'version' => 1,
//                            'user_id' => $user_id,
//                            'create_time' => date('Y-m-d H:i:s',$new_term['start_time']),
//                            'created' => date('Y-m-d H:i:s'),
//                            'expire_time' =>date('Y-m-d H:i:s',$new_term['end_time']),
//                        );
//                    } else {
                        //没有上过，创建记录
                        //(['>', 'created_at', $time])->
                        //print_r($term);die;
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'term_id' => $term['id'],
                            'started' => 2,
                            'version' => 1,
                            'user_id' => $user_id,
                            'create_time' => date('Y-m-d H:i:s',$term['start_time']),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => date('Y-m-d H:i:s',$term['end_time']),
                        );
                    //用户存在插入新的课程和用户的关系
                    $usercourse = new UserCourse();
                    $id = $usercourse->add($user_course);
                    Yii::warning(json_encode($id.'用户和课程的关系建立'));
                    //echo $id;die;  ok
                    //return $id;
                } else {
                    //用户不存在，创建用户，建立用户关系
                    $user = array('phone' => $this->mobile, 'password' => '');
                    $users = new User();
                    $new_user_id = $users->Signup($user);
                    if ($new_user_id) {
                        Order::updateAll(['user_id' => $new_user_id], "order_id = $order_id");
                        //会员添加成功
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'term_id' => $term['id'],
                            'started' => 2,
                            'version' => 1,
                            'user_id' => $new_user_id,
                            'create_time' => date('Y-m-d H:i:s',$term['start_time']),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => date('Y-m-d H:i:s',$term['end_time']),
                        );
                        $usercourse = new UserCourse();
                        $id = $usercourse->add($user_course);
                        Yii::warning(json_encode($id.'用户和课程的关系建立'));
                        //return $id;
                    }
                }
            }
        }
    }

    public function AddOrderBug($order)
    {
        Yii::warning(json_encode($order));
        $this->order_sn = trim($order['tid']);
        $this->order_status = $order['status'] ? $order['status'] : 'WAIT_SELLER_SEND_GOODS';
        $this->refund_state = $order['refund_state'] ? $order['refund_state'] : 'NO_REFUND';
        $this->consignee = $order['receiver_name'];
        $this->province = $order['receiver_state'];
        $this->city = $order['receiver_city'];
        $this->district = $order['receiver_district'];
        $this->address = $order['receiver_address'];
        $this->mobile = trim($order['receiver_mobile']);
        $this->shipping_type = $order['shipping_type'] ? $order['shipping_type'] : 'express';
        $this->goods_amount = $order['price'] ? $order['price'] : '0.00';
        $this->post_fee = $order['post_fee'] ? $order['post_fee'] : '0.00';
        $this->pay_fee = $order['payment'] ? $order['payment'] : '0.00';
        $this->refunded_fee = $order['refunded_fee'] ? $order['refunded_fee'] : '0.00';
        $this->order_amount = $order['total_fee'] ? $order['total_fee'] : '0.00';
        $this->created = $order['created'] ? $order['created'] : date('Y-m-d H:i:s');
        $this->sign_time = $order['sign_time'] ? $order['sign_time'] : date('Y-m-d H:i:s');
        $this->pay_time = $order['pay_time'] ? $order['pay_time'] : date('Y-m-d H:i:s');
        $this->consign_time = $order['consign_time'] ? $order['consign_time'] : date('Y-m-d H:i:s');
        $this->data = json_encode($order);

        //订单已经存在
        if (!$this->order_sn ) {
            return false;
        }
        //订单已经存在
        $findorder = Order::findOne(['order_sn' => trim($this->order_sn)]);
        if ( $findorder->order_id && $findorder->user_id ) {
            return false;
        }

        //$order_id = 8;
        if($findorder->order_id){
            $order_id = $findorder->order_id;
        }else{
            $order_id = $this->save() ? Yii::$app->db->lastInsertID : '';
        }

        Yii::warning(json_encode($order_id.'order_id存在'));
        if (!$order_id) {
            Yii::warning(json_encode($this->errors));
            return false;
        }

        foreach ($order['orders'] as $key => $param) {
            if($findorder->order_id){
                $rec_id = true;
            }else{
                $order_goods = new OrderGoods();
                $param['order_sn'] = $this->order_sn;
                $param['order_id'] = $order_id;
                $rec_id = $order_goods->AddOrderGoods($param);
            }
            //$rec_id = 7;
            if (!$rec_id) {
                Yii::warning(json_encode($this->errors));
                continue;
                //break;
            }
            Yii::warning(json_encode($rec_id.'rec_id存在'));
            //1.判断是不是课程：如果是就继续，如果不是课程，就执行完成；
            $code = trim($param['outer_item_id']);
            //$code = 'KY160001';
            //$sql = "SELECT course_id FROM `course` WHERE `code` = '".$code."'";
            $sql = "SELECT cs.course_id,cs.section_id,c.type
                    FROM `course_section` as cs
                    LEFT JOIN `course` as c ON cs.course_id = c.course_id
                    WHERE c.code = '{$code}' AND c.type in (1,3)";//and s.sort=1

            $courses = Yii::$app->db->createCommand($sql)->queryAll();
            if (!$courses) {
                Yii::warning(json_encode($this->errors));
                continue;
                //break;
            }
            Yii::warning(json_encode($courses.'课程存在'));
            //print_r($sql);die;
            foreach ($courses as $course) {
                // $expire_time = date('Y-m-d H:i:s', strtotime($course['expire_time']) + 86400 * 30 * 3);
                Yii::warning(json_encode($this->errors));
                if (!$course['course_id']) {
                    //Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                    continue;
                    //break;
                }
                //如果是免费课，不管购买几次，都只添加一次权限
                $usfree = UserCourse::find()->from(['uc' => UserCourse::tableName()])->select('id')
                    ->joinWith('section')
                    ->where([
                        'AND',
                        ['in','code',['KY160030','KC160031','KC160032']],
                        ['=','uc.section_id',$course['section_id']],
                    ])->count();
                //echo $usfree->createCommand()->getRawSql();die;
                //Yii::info($usfree,'test');
                if($usfree){
                    //Yii::info($usfree,'test');
                    continue;
                }

                //判断是阶段的那个学期
                $term = TermModel::find()->where(
                    [
                        'AND',['=','status',2],
                        ['=','section_id',$course['section_id']],
                        ['>=','order_end_time',strtotime($this->created)],
                        ['<=','order_start_time',strtotime($this->created)],
                        //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
                    ]
                )->asArray()->one();

                if (!$term) {
                    //Yii::getLogger()->log("有赞订单：{$order['tid']},不是课程");
                    continue;
                    //break;
                }
                if($course['type'] == 3){
                    $term['start_time'] = time();
                    $term['end_time'] = Yii::$app->params['course_expire'];
                }
                Yii::warning(json_encode($term.'阶段学期存在'));
                //$order['receiver_mobile'] = '18636342640';
                //3.查看订单手机号是否在用户表存在  $user 是对象
                $user = User::getUserByName($this->mobile);
                $course_id = $course['course_id'];
                if ($user->user_id) {
                    $user_id = $user->user_id;
                    Order::updateAll(['user_id' => $user_id], "order_id = $order_id");
                    //4.检查该用户是否已经上过该课程的阶段
//                    $sql = "select max(cs.sort) as sort from `section` as cs left join `user_course` as uc on cs.section_id = uc.section_id WHERE uc.course_id = '{$course_id}' and uc.user_id = '{$user_id}'";
//                    //echo $sql;die;
//                    $user_max_sort = Yii::$app->db->createCommand($sql)->queryOne();
//                    //print_r($user_max_sort);die;
//                    if ($user_max_sort['sort']) {
//                        //上过该课程，需要创建新的阶段课程
//                        $sql = "select min(s.sort) as sort from `section` as s
//                                left join `course_section` as cs on s.section_id = cs.section_id
//                                WHERE cs.course_id = '{$course_id}' and s.sort>'{$user_max_sort['sort']}'";
//                        //echo $sql;die;
//                        $user_next_section = Yii::$app->db->createCommand($sql)->queryOne();
//                        //没有最新阶段
//                        if (!$user_next_section['sort']) {
//                            continue;
//                            //break;
//                        }
//                        //print_r($user_next_section);die;
//                        $sql = "select s.* from `section` as s
//                                left join `course_section` as cs on s.section_id = cs.section_id
//                                WHERE cs.course_id = '{$course_id}' and s.sort='{$user_next_section['sort']}'";
//                        //echo $sql;die;
//                        $new_section = Yii::$app->db->createCommand($sql)->queryOne();
//
//                        //判断用户是该阶段下的那个学期
//                        //order_start_time<=$this->created<=order_end_time
//                        $new_term = TermModel::find()->where(
//                            [
//                                'AND',['=','status',2],
//                                ['=','section_id',$new_section['section_id']],
//                                ['>=','order_end_time',strtotime($this->created)],
//                                ['<=','order_start_time',strtotime($this->created)],
//                                //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
//                            ]
//                        )->asArray()->one();
//                        if($course['type'] == 3){
//                            $new_term['start_time'] = time();
//                            $new_term['end_time'] = Yii::$app->params['course_expire'];
//                        }
//
//                        //print_r($term);die;
//                        //$expire_time = date('Y-m-d H:i:s', strtotime($new_section['expire_time']) + 86400 * 30 * 3);
//                        $user_course = array(
//                            'course_id' => $new_section['course_id'],
//                            'section_id' => $new_section['section_id'],
//                            'term_id' => $new_term['id'],
//                            'started' => 2,
//                            'version' => 1,
//                            'user_id' => $user_id,
//                            'create_time' => date('Y-m-d H:i:s',$new_term['start_time']),
//                            'created' => date('Y-m-d H:i:s'),
//                            'expire_time' =>date('Y-m-d H:i:s',$new_term['end_time']),
//                        );
//                    } else {
                        //没有上过，创建记录
                        //(['>', 'created_at', $time])->
                        //print_r($term);die;
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'term_id' => $term['id'],
                            'started' => 2,
                            'version' => 1,
                            'user_id' => $user_id,
                            'create_time' => date('Y-m-d H:i:s',$term['start_time']),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => date('Y-m-d H:i:s',$term['end_time']),
                        );

                    //用户存在插入新的课程和用户的关系
                    $usercourse = new UserCourse();
                    $id = $usercourse->add($user_course);
                    Yii::warning(json_encode($id.'用户和课程的关系建立'));
                    //echo $id;die;  ok
                    //return $id;
                } else {
                    //用户不存在，创建用户，建立用户关系
                    $user = array('phone' => $this->mobile, 'password' => '');
                    $users = new User();
                    $new_user_id = $users->Signup($user);
                    if ($new_user_id) {
                        Order::updateAll(['user_id' => $new_user_id], "order_id = $order_id");
                        //会员添加成功
                        $user_course = array(
                            'course_id' => $course['course_id'],
                            'section_id' => $course['section_id'],
                            'term_id' => $term['id'],
                            'started' => 2,
                            'version' => 1,
                            'user_id' => $new_user_id,
                            'create_time' => date('Y-m-d H:i:s',$term['start_time']),
                            'created' => date('Y-m-d H:i:s'),
                            'expire_time' => date('Y-m-d H:i:s',$term['end_time']),
                        );
                        $usercourse = new UserCourse();
                        $id = $usercourse->add($user_course);
                        Yii::warning(json_encode($id.'用户和课程的关系建立'));
                        //return $id;
                    }
                }
            }
        }
    }

    public function getInfo($order_sn='',$mobile=''){

        $sql = "SELECT oi.order_id,oi.order_sn,oi.user_id,oi.order_status,oi.refund_state,oi.address,oi.mobile
              FROM order_info as oi";

        $where = [];
        if ($order_sn) {
            $where[] = "oi.order_sn = '$order_sn'";
        }
        if ($mobile) {
            $where[] = "oi.mobile = '$mobile'";
        }
        if ($where) {
            $sql .= ' where ' . implode(' and ', $where);
        }

        $sql = $sql .' order by oi.order_id desc';

        //echo $sql;die;
        $result = Yii::$app->db->createCommand($sql)->query();

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $result->rowCount,
        ]);
        $result = Yii::$app->db->createCommand($sql . " LIMIT $pagination->offset,$pagination->limit");
        $order = $result->queryAll();
        foreach ($order as $key=>$value){
            $sql = "select code,goods_name,goods_number from order_goods where order_id = '{$value['order_id']}'";
            $order_goods = Yii::$app->db->createCommand($sql)->queryAll();
            $order[$key]['goods'] = $order_goods;
        }
        $orders = array('order' => $order, 'page' => $pagination);
        return $orders;
    }

    public static function tableName()
    {
        return 'order_info';
    }


}