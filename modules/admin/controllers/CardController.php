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
use app\models\CourseSection;
use app\models\search\CardSearchModel;
use app\models\Section;
use app\models\TermModel;
use app\models\Tool;
use yii\web\Controller;
use Yii;
use yii\helpers\Html;
use moonland\phpexcel\Excel;


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
                                    if ($cardVal->user_id == 0 && $cardVal->course_id == 0 && $cardVal->status == 2 && $cardVal->is_useable == 1
                                        && $cardVal->is_used == -1 && $cardVal->is_active == -1 && $cardVal->is_cancel == -1){
                                        $cardInfos = CardModel::findOne($cardVal->id);
                                        if ($cardInfos) {
                                            $cardInfos->course_id = $model->course_id;
                                            $cardInfos->section_id = $model->section_id;
                                            $cardInfos->term_id = $model->term_id;
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
                            //die('没有符合的卡信息');
                            return $this->redirect('activate');
                        }
                    } else {
                        //die('卡段有误');
                        return $this->redirect('activate');
                    }
                } else {
                    //die('卡段不存在');
                    return $this->redirect('activate');
                }
            } else {
                //die('时间不符合');
                return $this->redirect('activate');
            }

        } else {
            $classData = ClassModel::getNames(ClassModel::className());
            return $this->render('activate', [
                'model' => $model,
            ]);
        }
        //print_r($classData);
        //die;
    }

    public function actionCourses()
    {

        $cateId = Yii::$app->request->post('cateId');
        $typeId = Yii::$app->request->post('typeId');


        //$data = intval($cateId) ? $model->getAreaList($cateId) : '';
        if (intval($cateId)) {
            $data = CourseSection::find()->andWhere(['course_id' => $cateId])->all();
            if ($data) {
                $newArray = [];
                foreach ($data as $key => $val) {
                    if ($val->section_id) {
                        $sectionInfo = Section::findOne($val->section_id);
                        $newArray[] = [$val->section_id => $sectionInfo->name];
                    }
                }
            }
        } else {
            $newArray = [];
        }

        if (!intval($cateId)) {
            if ($typeId == 1) {
                echo Html::tag('option','--请选择阶段--',['value'=>'empty']);
            } else {
                echo Html::tag('option','--请选择学期--',['value'=>'empty']);
            }
        }

        if($typeId == 1){
            $aa="--请选择阶段--";
        }else if($typeId == 2 && $newArray){
            $aa="--请选择学期--";
        }

        echo Html::tag('option',$aa, ['value'=>'empty']) ;

        foreach($newArray as $key => $name)
        {
            foreach($name as $k => $v) {
                echo Html::tag('option', Html::encode($v), ['value' => $k]);
            }
        }

    }

    public function actionSections()
    {
        $cateId = Yii::$app->request->post('cateId');
        $typeId = Yii::$app->request->post('typeId');

        //$data = intval($cateId) ? $model->getAreaList($cateId) : '';
        if (intval($cateId)) {
            $data = TermModel::find()->andWhere(['section_id' => $cateId])->asArray()->all();

        } else {
            $data = [];
        }


        if (!intval($cateId)) {
            if ($typeId == 1) {
                echo Html::tag('option','--请选择阶段--',['value'=>'empty']);
            } else {
                echo Html::tag('option','--请选择学期--',['value'=>'empty']);
            }
        }

        if($typeId == 1){
            $aa="--请选择阶段--";
        }else if($typeId == 2 && $data){
            $aa="--请选择学期--";
        }

        echo Html::tag('option',$aa, ['value'=>'empty']) ;


        foreach($data as $key => $name)
        {
            echo Html::tag('option', Html::encode($name['term']), ['value' => $name['id']]);
        }

    }


    /**
     * @param $status
    '1' => '已激活（已卖出）',
    '2' => '未激活（需印刷）',
    '3' => '作废',
    '4' => '已使用',
    '5' => '过期（未使用过期）',
     * @param $num 需要导出多少卡号
     * @return \yii\web\Response
     */
    public function actionCardExport()
    {
        $cardModel = new CardModel();
        $cardModel->setScenario('export');
        if($cardModel->load(Yii::$app->request->post())){

            $status = $cardModel->statuss;
            $number = $cardModel->number;
//            echo '<pre>';
//            print_r($cardModel);
//            die;
            //'1' => '已激活（已卖出）',
            if($status == 1){
                $result = CardModel::find()->where([
                    'is_useable' => 1 , 'is_used' => -1 , 'is_active' => 1 , 'is_cancel' => -1 ,
                ])->asArray()->orderBy('created_at desc')->limit($number)->all();
            }

            //'2' => '未激活（需印刷）',
            if($status == 2){
                $result = CardModel::find()->where([
                    'is_useable' => 1 , 'is_used' => -1 , 'is_active' => -1 , 'is_cancel' => -1 ,
                ])->asArray()->orderBy('created_at desc')->limit($number)->all();
            }

            //'3' => '作废',
            if($status == 3){
                $result = CardModel::find()->where([
                    'is_useable' => -1 , 'is_used' => 1 , 'is_active' => 1 , 'is_cancel' => 1 ,
                ])->asArray()->orderBy('created_at desc')->limit($number)->all();
            }
            //'4' => '已使用',
            if($status == 4){
                $result = CardModel::find()->where([
                    'is_useable' => -1 , 'is_used' => 1 , 'is_active' => 1 , 'is_cancel' => -1 ,
                ])->asArray()->orderBy('created_at desc')->limit($number)->all();
            }

            //'5' => '过期（未使用过期）',
            if($status == 5){
                $result = CardModel::find()->where([
                    'is_useable' => -1 , 'is_used' => -1 , 'is_active' => 1 , 'is_cancel' => 1 ,
                ])->asArray()->orderBy('created_at desc')->limit($number)->all();
            }

            if(!$result){
                return $this->redirect('index');
            }
            Excel::export([
                'models' => $result,
                'fileName'=> date('Ymd').'_'.'Export',
                'format' => 'Excel5',
                'columns' => ['id','code','password','is_useable','is_used','is_active','is_cancel','expired_at','created_at'],
                'headers' => ['id' => 'ID','code' => '卡号', 'password' => '密码','is_useable'=> '是否可用',
                    'is_used'=> '是否兑换','is_active'=> '是否激活','is_cancel'=> '是否作废','expired_at'=> '截止日期','created_at'=> '创建时间'],
            ]);
        }
        return $this->render('export', ['model' => $cardModel]);
    }



}