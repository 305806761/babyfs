<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/21
 * Time: 15:59
 */

namespace app\modules\admin\controllers;

use app\models\OrderGoods;
use app\models\SectionCat;
use app\models\TermModel;
use app\models\UserCourse;
use Yii;
use yii\web\Controller;
use app\models\Order;

class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $order = new Order();
        if(Yii::$app->request->post()){
            $order_sn = Yii::$app->request->post('order_sn');
            $mobile = Yii::$app->request->post('mobile');
            $orders = $order->getInfo($order_sn,$mobile);
        }else{
            $orders = $order->getInfo();
        }
        //print_r($orders);die;
        return $this->render('list',['orders'=>$orders]);
    }

    public function actionUpdateUcourse(){
        $section_id = Yii::$app->request->get('section_id');
        if($section_id){

            $term = TermModel::findAll(['section_id'=>$section_id]);
            foreach ($term as $value){
//                echo "<pre>";
//                print_r($value);die;
                $expire_time = date('Y-m-d',$value->end_time);
                //echo $expire_time;die;
                $user_course = UserCourse::updateAll(['term_id'=>$value->id],"section_id = $value->section_id AND expire_time like '{$expire_time}%'");
                if($user_course){
                    echo "成功".$user_course;
                }else{
                    echo '失败'. $user_course;
                }
            }

        }
    }

    public function actionTest(){
        $section_id = Yii::$app->request->get('section_id');
        $sectionInfo = Section::findOne($section_id);
        if ($sectionInfo->section_id >0) {
            $termInfos = TermModel::findOne(['section_id' => $sectionInfo->section_id, 'term' => '1']);
            if (!empty($termInfos)) {
                //$catInfos = SectionCat::findAll(['section_id' => $sectionInfo->section_id]);
                //echo $termInfos->section_id,$termInfos->id;
                $result = SectionCat::updateAll(['term_id' => $termInfos->id], "section_id = $termInfos->section_id");
                echo '成功'.$result;

            }
        }
        echo '失败';
    }



}