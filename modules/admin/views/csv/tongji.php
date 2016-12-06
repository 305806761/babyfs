<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/2
 * Time: 下午4:11
 */




use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->registerJs("var _opts = $opts;");
//$this->registerJs($this->render('_script.js'));


$this->title = "列表";
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="wrapper">
  <!-- page start-->
  <div class="row">
      <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">
            订单统计功能
            </header>
              <div class="panel-body">
                  <div class="panel-body">
                      <?php $form = ActiveForm::begin([
                          'options'=>[
                              'class' => 'form-horizontal',
                              'enctype' => 'multipart/form-data',
                          ]
                      ]); ?>

                      <div class="form-group field-term ">
                          <label class="col-lg-2 control-label" for="term">下单时间</label>
                          <div class="col-lg-3">
                              <input id="order_add_time" type="text" readonly="readonly" size="12" name="order_add_time"
                                     value="<?=$time?>"/>
                              <input id="selbtn1" class="button" type="button" value="选择"
                                     onclick="return showCalendar('order_add_time', '%Y-%m-%d', false, false, 'selbtn1');"
                                     name="selbtn1">
                          </div>
                          <div style="float: left;" class="col-lg-offset-0 col-lg-1">
                              <?php
                              echo Html::submitButton('查询', [
                                  'class' => 'btn btn-danger'])
                              ?>
                          </div>
                      </div>

                      <?php ActiveForm::end(); ?>
                  </div>

                  <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>这是空的</th>
                        <?php foreach($courseModel as $oneKey => $oneVal):?>
                            <th><?=$oneVal['name']?></th>
                        <?php endforeach; ?>
                            <th>课程总数</th>
                            <th>总额</th>
                            <th>提成总额</th>
                            <th>实收总额</th>
                        </tr>
                        </thead>
                      <tbody>
                      <?php foreach($groupModel as $twoKey => $twoVal):?>
                          <tr>
                              <td><?=$twoVal['name']?>/<?=$twoVal['code']?></td>
                              <?php
                                $allMoney = 0;
                                $allNumber =0;
                                $myMoney = 0;
                                $surplusMoney = 0;
                                foreach($courseModel as $threeKey => $threeVal) {
                                    $count = 0;
                                    $aMoney = 0;
                                    $mMoney = 0;
                                    $sMoney = 0;
                                    //课程购买的数量
                                    $count = \app\models\CsvModel::find()
                                        ->where(['code' => $threeVal['code']])
                                        ->andWhere(['subcategory_code' => $twoVal['code']])
                                        ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                        ->sum('number');
                                    $allNumber += $count;
                                    //总金额
                                    if ($count) {
                                        $aMoney = \app\models\CsvModel::find()
                                            ->where(['code' => $threeVal['code']])
                                            ->andWhere(['subcategory_code' => $twoVal['code']])
                                            ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                            ->sum('all_money');
                                        $allMoney += $aMoney;
                                    } else {
                                        //$allMoney = 0;
                                    }
                                    //总提成
                                    if ($count) {
                                        $mMoney = \app\models\CsvModel::find()
                                            ->where(['code' => $threeVal['code']])
                                            ->andWhere(['subcategory_code' => $twoVal['code']])
                                            ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                            ->sum('my_money');
                                        $myMoney += $mMoney;
                                    } else {
                                        //$myMoney = 0;
                                    }

                                    //总收益金额
                                    if ($count) {
                                        $sMoney = \app\models\CsvModel::find()
                                            ->where(['code' => $threeVal['code']])
                                            ->andWhere(['subcategory_code' => $twoVal['code']])
                                            ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                            ->sum('surplus_money');
                                        $surplusMoney += $sMoney;
                                    } else {
                                        //$surplusMoney = 0;
                                    }


                                    if ($count > 0) {
                                        echo '<td style="background-color: #cd0a0a; text-align:center; vertical-align:middle;" class="numeric">'.$count.'</td>';
                                    } else {
                                        echo '<td class="numeric">'.$count.'</td>';
                                    }


                                }

                              ?>

                              <td style="background-color: #00aa00; text-align:center; vertical-align:middle;"><?=$allNumber?></td>
                              <td style="background-color: #ffff38; text-align:center; vertical-align:middle;"><?=$allMoney?></td>
                              <td style="background-color: #fd454a; text-align:center; vertical-align:middle;"><?=$myMoney?></td>
                              <td style="background-color: #2293f7; text-align:center; vertical-align:middle;"><?=$surplusMoney?></td>

                          </tr>
                      <?php endforeach; ?>
                      <tr>
                          <td>其他</td>
                          <?php
                          $eallMoney = 0;
                          $eallNumber =0;
                          $emyMoney = 0;
                          $esurplusMoney = 0;
                          foreach($courseModel as $ethreeKey => $ethreeVal) {
                              $ecount = 0;
                              $eaMoney = 0;
                              $emMoney = 0;
                              $esMoney = 0;
                              //课程购买的数量
                              $ecount = \app\models\CsvModel::find()
                                  ->where(['code' => $ethreeVal['code']])
                                  ->andWhere(['subcategory_code' => 'error', 'category_id' => 0])
                                  ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                  ->sum('number');
                              $eallNumber += $ecount;
                              //总金额
                              if ($ecount) {
                                  $eaMoney = \app\models\CsvModel::find()
                                      ->where(['code' => $ethreeVal['code']])
                                      ->andWhere(['subcategory_code' => 'error', 'category_id' => 0])
                                      ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                      ->sum('all_money');
                                  $eallMoney += $eaMoney;
                              } else {
                                  //$allMoney = 0;
                              }
                              //总提成
                              if ($ecount) {
                                  $emMoney = \app\models\CsvModel::find()
                                      ->where(['code' => $ethreeVal['code']])
                                      ->andWhere(['subcategory_code' => 'error', 'category_id' => 0])
                                      ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                      ->sum('my_money');
                                  $emyMoney += $emMoney;
                              } else {
                                  //$myMoney = 0;
                              }

                              //总收益金额
                              if ($ecount) {
                                  $esMoney = \app\models\CsvModel::find()
                                      ->where(['code' => $ethreeVal['code']])
                                      ->andWhere(['subcategory_code' => 'error', 'category_id' => 0])
                                      ->andWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d\')', strtolower($time)])
                                      ->sum('surplus_money');
                                  $esurplusMoney += $esMoney;
                              } else {
                                  //$surplusMoney = 0;
                              }


                              if ($ecount > 0) {
                                  echo '<td style="background-color: #cd0a0a; text-align:center; vertical-align:middle;" class="numeric">'.$ecount.'</td>';
                              } else {
                                  echo '<td class="numeric">'.$ecount.'</td>';
                              }


                          }

                          ?>

                          <td style="background-color: #00aa00; text-align:center; vertical-align:middle;"><?=$eallNumber?></td>
                          <td style="background-color: #ffff38; text-align:center; vertical-align:middle;"><?=$eallMoney?></td>
                          <td style="background-color: #fd454a; text-align:center; vertical-align:middle;"><?=$emyMoney?></td>
                          <td style="background-color: #2293f7; text-align:center; vertical-align:middle;"><?=$esurplusMoney?></td>

                      </tr>

                      </tbody>
                  </table>
                  </section>
              </div>
          </section>
      </div>
  </div>
  <!-- page end-->
</section>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css"/><section class="wrapper site-min-height">