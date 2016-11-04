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
}



