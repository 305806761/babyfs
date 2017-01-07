<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/11/4
 * Time: 23:23
 */
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;

class RcodeController extends Controller{

    public $enableCsrfValidation = false;
    public function actionGetQrcode()
    {
        //enableCsrfValidation
        $url = Yii::$app->request->post('url');
        if ($url) {
            echo Text::widget(
                ['outputDir' => '@webroot/upload/qrcode',
                    'outputDirWeb' => '@web/upload/qrcode',
                    'ecLevel' => QRcode::QR_ECLEVEL_L,
                    'text' => "$url",
                    'size' => 6,]);die;
        }
        return $this->render('qrcode');

    }

    public function actionSql(){

        if(Yii::$app->request->post()){

            $sql = Yii::$app->request->post('sql');
            $result = Yii::$app->db->createCommand($sql)->query();
            if($result){
                echo "执行成功!";die;
            }else{
                echo "执行失败";die;
            }
        }

        return $this->render('sql');
    }

    public function actionGetFreeUrl(){
        $section_id = Yii::$app->request->post('section_id');
        $term_id = Yii::$app->request->post('term_id');
        $time = Yii::$app->request->post('time');
        if($section_id && $term_id && $time){
            $end_time = strtotime($time);
            $etime = base64_encode($end_time);//加密
            echo "http://cs.babyfs.cn/section/free?section_id=".$section_id."&term_id=".$term_id."&time=".$etime;die;
        }
        return $this->render('get_url');
    }
}



