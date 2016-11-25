<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/24
 * Time: 下午10:53
 */

namespace app\controllers;


use app\models\BabyOneModel;
use yii;
use yii\web\Controller;

/**
 * Site controller
 */
class BabyController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'hfive';
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        //$model = $this->save();
        return $this->render('index', [
            //'model' => $model,
        ]);

    }

    /**
     * 英语测试
     */
    public function actionTest()
    {
        $model = new BabyOneModel();

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->save()) {
                echo json_encode(["status" => "ok", "id" => $model->id]);
            } else {
                echo json_encode(["status"=>"error"]);
            }
        } else {
            echo json_encode(["status"=>"no"]);
        }
    }

    public function actionAdd()
    {
        $userId = (int)Yii::$app->request->post('userid');
        $answer = (int)Yii::$app->request->post('answerid');
        if ($userId && $answer) {
            $model = new BabyOneModel();
            $findModel = $model::findOne($userId);
            if ($findModel->id > 0) {
                if ($answer == 1 || $answer == 2) {
                    $findModel->one = $answer;
                } else if ($answer == 3 || $answer == 4) {
                    $findModel->two = $answer;
                } else if ($answer == 5 || $answer == 6) {
                    $findModel->three = $answer;
                }
                if ($findModel->save()) {
                    echo json_encode(['status' => 'ok']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            } else {
                echo json_encode(['status' => 'error1']);
            }
        } else {
            echo json_encode(['status' => 'error2']);
        }

    }

}