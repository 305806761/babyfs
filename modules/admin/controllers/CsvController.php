<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 上午11:22
 */

namespace app\modules\admin\controllers;


use app\models\Course;
use app\models\GroupModel;
use app\models\search\CsvSearchModel;
use yii\web\Controller;
use Yii;
use app\models\CsvModel;
use app\models\PriceModel;

class CsvController extends Controller
{
    public $enableCsrfValidation = false;


    public static $orderStatus = [
        '1' => '等待商家发货',
        '2' => '商家已发货',
        '3' => '该商品维权已撤销',
        '4' => '交易已完成',
    ];

    /**
     * @列表
     * @return string
     */
    public function actionIndex()
    {
        $model = new CsvSearchModel();
        $dataProvider = $model->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
        ]);
    }


    //统计课程
    public function actionTongji(){
        $date = Yii::$app->request->post('order_add_time');

        $groupModel = GroupModel::find()->asArray()->all();
        $courseModel = Course::find()->where(['type' => 1])->asArray()->all();


        return $this->render('tongji', [
            'groupModel' => $groupModel,
            'courseModel' => $courseModel,
            'time' => $date,

        ]);
    }

    //统计绘本
    public function actionStatistics(){

        $date = Yii::$app->request->post('order_add_time');
        $groupModel = GroupModel::find()->asArray()->all();
        $courseModel = Course::find()->where(['type' => 2])->asArray()->all();

        return $this->render('statistics', [
            'groupModel' => $groupModel,
            'courseModel' => $courseModel,
            'time' => $date,

        ]);
    }


    /**
     * order订单csv文件导入
     * @param string id user_course(id)
     * @return boolean
     * @access public
     */
    public function actionCsvUp()
    {

        if (Yii::$app->request->post()) {

            if (isset($_FILES['csv_order']['tmp_name']) && $_FILES['csv_order']['tmp_name']) {
                //$path_parts = pathinfo($param['user_course']['name']);
                $file = 'order_csv.csv'; //可以定义一个上传后的文件名称uploadFile.xlsx
                $filename = '/uploads/order/' . $file;
                $filePath = Yii::getAlias('@webroot' . $filename);
                copy(
                    $_FILES['csv_order']['tmp_name'],
                    $filePath
                );
                $fp = fopen($filePath, 'r');
                while ( ($row = fgetcsv($fp)) !== FALSE ) {
                    //从文件指针中读入一行并解析CSV
                    $arr[] = $row;
                }

                $error = 0;
                $success = 0;

                foreach($arr as $key => $row) {
                    if ($key >= 9) {

                        if ($row['3']) {
                            $orderStatus = array_search(iconv('gb2312', 'utf-8', $row['3']), self::$orderStatus);
                            //echo $orderStatus . "----" . $row['3'] . '-----' . self::$orderStatus . "<br />";
                            if ($orderStatus) {
                                //echo $orderStatus;
                                if ($row['46']) {
                                    $model = new CsvModel();
                                    $model->order_status = $orderStatus;
                                    if (trim($row['4'])) {
                                        $site = preg_replace('/\D/s', '', trim($row['4']));
                                        //这个地方根据code得出组id，组名，会员code
                                        //echo $site ? $site : $row['4'];

                                        //$groupModel = new GroupModel();
                                        //if ($groupModel) {
                                        $result = GroupModel::find()
                                            ->where(['code' => $site])
                                            ->one();
                                        if ($result) {
                                            //echo $result->code."----";
                                            //echo "<br />";
                                            $model->category_id = $result->id;
                                            $model->category_name = $result->name;
                                            $model->subcategory_code = $result->code;
                                            if ($model->category_id && !$row['8']) {
                                                $model->type = 0;
                                            } else {
                                                $model->type = 1;
                                            }
                                        } else {
                                            $model->category_id = 0;
                                            $model->category_name = '已经退出的组';
                                            $model->subcategory_code = 'error';
                                            $model->type = 0;
                                            //continue;
                                        }

                                        //}

                                    } else {
                                        $model->category_name = '';
                                        $model->category_id = 0;
                                        $model->subcategory_code = '';
                                        $model->type = 0;
                                        //continue;

                                    }

                                    $code = trim($row['15']) ? trim($row['15']) : trim($row['16']);
                                    $model->number = $row['37'];
                                    if ($code) {
                                        $model->code = $code;
                                        //这个地方根据根据code得出各种价格
                                        //$priceModel = new PriceModel();
                                        $priceResult = PriceModel::find()
                                            ->where(['code' => $code])
                                            ->one();

                                        //echo "<pre>";
                                        //echo $site;
                                        //print_r($priceResult);
                                        //die;

                                        if ($priceResult) {
                                            if ($priceResult->type && $priceResult->price && $priceResult->type) {
                                                $model->money_type = $priceResult->type;
                                                $model->alone_money = $priceResult->price;

                                                if ($priceResult->type == 1) {
                                                    //价格减0.01然后乘以百分之20
                                                    $model->all_money = $this->cutNumber($priceResult->price * $model->number);
                                                    $model->my_money = $this->cutNumber(($priceResult->price - ($priceResult->price * 0.8 - 0.01)) * $model->number);
                                                    $model->surplus_money = $this->cutNumber($model->all_money - $model->my_money);

                                                } else if ($priceResult->type == 2) {
                                                    //减去0.01，没有提成
                                                    $model->all_money = $this->cutNumber($priceResult->price * $model->number);
                                                    $model->my_money = 0.00;
                                                    $model->surplus_money = $this->cutNumber(($model->all_money - 0.01) * $model->number);
                                                } else if ($priceResult->type == 3) {
                                                    //减去0.05，没有提成
                                                    $model->all_money = $this->cutNumber($priceResult->price * $model->number);
                                                    $model->my_money = 0.00;
                                                    $model->surplus_money = $this->cutNumber(($model->all_money - 0.05) * $model->number);
                                                } else if ($priceResult->type == 4) {
                                                    //78不减，38百分之二十的提成
                                                    $model->all_money = $this->cutNumber((78 + 38) * $model->number);
                                                    $model->my_money = $this->cutNumber((38 - ((38 * 0.8) - 0.01)) * $model->number);
                                                    $model->surplus_money = $this->cutNumber($model->all_money - $model->my_money);
                                                } else {
                                                    $model->all_money = 0.00;
                                                    $model->my_money = 0.00;
                                                    $model->surplus_money = 0.00;
                                                }
                                            } else {
                                                $model->all_money = 0.00;
                                                $model->my_money = 0.00;
                                                $model->surplus_money = 0.00;
                                            }
                                        } else {
                                            $model->all_money = 0.00;
                                            $model->my_money = 0.00;
                                            $model->surplus_money = 0.00;
                                        }
                                    } else {

                                        $model->code = '';
                                        $model->all_money = 0.00;
                                        $model->my_money = 0.00;
                                        $model->surplus_money = 0.00;
                                    }

                                    $model->order_sn = trim($row['0']);
                                    $model->subcategory_name = '--' . iconv('gb2312', 'utf-8', $row['4']); //中文转码 ;
                                    $model->should_pay = $row['9'];
                                    $model->all_pay = $row['11'];
                                    $model->real_pay = $row['12'];
                                    $model->order_add_time = strtotime($row['30']);
                                    $model->order_pay_time = strtotime($row['31']);
                                    $model->title = iconv('gb2312', 'utf-8', $row['34']); //中文转码
                                    $model->price = $row['35'];
                                    $model->people_pay = $row['47'];
                                    $model->year = date("Y", strtotime($row['30']));
                                    $model->month = date("n", strtotime($row['30']));
                                    $model->day = date("j", strtotime($row['30']));


                                    $stmt = $model->save();
                                    if ($stmt) {
                                        $success++;
                                    } else {
                                        echo "<pre>";
                                        print_r($model->errors);
                                        $error++;
                                    }

                                    $key++;
                                }
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        }

                    }

                }


                $msg = '成功'.$success.'-------失败'.$error.'-----总条数'.$key;
                return $this->render('msg', [
                    'msg' => $msg,
                ]);

            }
        }
        return $this->render('csv_up');
    }


    /**
     * @param $number
     * @小数截取两位小数，不四舍五入
     */
    public function cutNumber($number) {
        return substr(sprintf("%.3f", $number),0,-1);
    }

}