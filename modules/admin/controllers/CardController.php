<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午3:22
 */

namespace app\modules\admin\controllers;


use app\models\CardModel;
use app\models\ClassModel;
use app\models\search\CardSearchModel;
use app\models\Tool;
use yii\web\Controller;
use Yii;
use yii\db\Connection;

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
     * @获取到卡的前缀和需要的数量。生成卡
     */
    public function actionCreate(){
        $model = new CardModel();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post())) {
            $error = 0;
            $success = 0;
            $maxCode = CardModel::find()->select('code')->max('code');

            if($maxCode){
                //echo $maxCode.'---';
                $num1 = substr($maxCode, 8, 8) + 1;
            } else {
                $num1 = '1';
            }
            $cardSn = $model->card_sn ? $model->card_sn : '88888888';

            for ($i = 0; $i < $model->number; $i++) {
                //==============生成礼品册用户名和密====.
                $num2 = $num1 + $i;
                $num3 = str_pad($num2,8,"0",STR_PAD_LEFT);

                $newcode = $cardSn . $num3;

                $passWord = Tool::getRandWord(6);
                $newCardModel = new CardModel();
                $newCardModel->number = $model->number;
                $newCardModel->card_sn = $cardSn;
                $newCardModel->code = $newcode;
                $newCardModel->password = $passWord;
                if ($newCardModel->save()) {
                    $success++;
                } else {
                    $error++;
                    //print_r($newCardModel->errors);
                }
            }
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 激活
     */
    public function actionActivate(){

        $model = new CardModel();
        $model->setScenario('activate');
        if ($model->load(Yii::$app->request->post())) {


            $model->expired_at = strtotime($model->expired_at);
            $time = strtotime(date("Y-m-d"));

            if($model->expired_at > $time){
                $startInfo = CardModel::find()
                    ->where(['code' => $model->start_code])
                    ->andWhere(['status' => CardModel::STATUS_ACTIVE])
                    ->one();
                $endInfo = CardModel::find()
                    ->where(['code' => $model->end_code])
                    ->andWhere(['status' => CardModel::STATUS_ACTIVE])
                    ->one();
                if ($startInfo && $endInfo) {
                    if ($endInfo->id >= $startInfo->id) {
                        $cardInfo = CardModel::find()
                            ->where(['>=', 'id', $startInfo->id])
                            ->andWhere(['<=', 'id', $endInfo->id])
                            ->all();

                        if ($cardInfo) {
                            $connection = Yii::$app->db->beginTransaction();
                            $success= 0;
                            $error = 0;
                            try {
                                foreach ($cardInfo as $cardKey => $cardVal) {
                                    if ($cardVal->user_id == 0 && $cardVal->class_id == 0 && $cardVal->status == 2 && $cardVal->is_useable == 1
                                        && $cardVal->is_used == -1 && $cardVal->is_active == -1 && $cardVal->is_cancel == -1){
                                        $cardInfos = CardModel::findOne($cardVal->id);
                                        if ($cardInfos) {
                                            $cardInfos->class_id = $model->class_id;
                                            $cardInfos->expired_at = $model->expired_at;
                                            $cardInfos->is_active = 1;
                                            if ($cardInfos->save()) {
                                                $success++;
                                            } else {
                                                $error++;
                                                throw new \Exception('数据异常！');
                                            }
                                        } else {
                                            $error++;
                                            throw new \Exception('数据异常！');
                                        }

                                    } else {
                                        $error++;
                                        throw new \Exception('数据异常！');

                                    }
                                    $cardKey++;
                                }
                                //以上执行都成功，则对数据库进行实际执行
                                $connection->commit();
                                echo '执行成功'.$success;
                            } catch (\Exception $e) {
                                $connection->rollBack();
                                echo '数据有异常';
                            }

                        } else {
                            die('没有符合的卡信息');
                        }
                    } else {
                        die('卡段有误');
                    }
                } else {
                    die('卡段不存在');
                }
            } else {
                die('时间不符合');
            }

        } else {
            $classData = ClassModel::getNames(ClassModel::className());
            return $this->render('activate', [
                'model' => $model,
                'classData' => $classData,

            ]);
        }
        //print_r($classData);
        //die;
    }



}