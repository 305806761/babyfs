<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午3:22
 */

namespace app\modules\admin\controllers;


use app\models\CardModel;
use app\models\search\CardSearchModel;
use app\models\Tool;
use yii\web\Controller;
use Yii;

class CardController extends Controller
{
    /**
     * @列表
     */
    public function actionIndex(){
        $model = new CardSearchModel();
        $dataProvider = $model->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     * @添加
     */
    public function actionCreate(){
        $model = new CardModel();
        //卡号
        if ($model->load(Yii::$app->request->post())) {
            //$model->password = Tool::getRandWord(7);

            $error = 0;
            $success = 0;
            for ($number = 1; $number <= $model->number; $number++){
                $newModel = new CardModel();
                $newModel->number = 1;
                //密码
                $newModel->password = Tool::getRandWord(7);
                //卡号
                $newModel->code = Tool::getRandCode(12);
                //每次循环，将卡号放入数组，判断生成的卡号在数组中是否已经存在。
                $newModel->is_useable = 0;
                $newModel->is_used = 0;
                $newModel->is_active = 0;
                $newModel->is_cancel = 0;

                if($newModel->save()) {
                    $success++;
                } else {
                    $error++;
                }
            }

            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }




}