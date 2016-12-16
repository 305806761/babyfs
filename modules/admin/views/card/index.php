<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 上午11:34
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = "列表";
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="wrapper site-min-height">
    <!-- page start-->
    <section class="panel">
        <header class="panel-heading">
            <?=$this->title?>
        </header>
        <div class="panel-body">
            <div class="clearfix">
                <div class="btn-group">
                    <?= Html::a('添加<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;']) ?>
                </div>
            </div>
            <div class="adv-table editable-table ">
                <div class="space15"></div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => [
                        'class' => 'table table-striped table-hover table-bordered',
                        'id' => 'editable-sample',
                    ],

                    'layout'=> '{items}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="dataTables_info" id="editable-sample_info">{summary}</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">{pager}</div>
                                    </div>
                                </div>',
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['width' => '100'],
                        ],


                        [
                            'attribute' => 'code',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'attribute' => 'password',
                            'headerOptions' => ['width' => '100'],
                        ],


                        [
                            'attribute' =>'users.phone',
                            'contentOptions' => [
                                'class' => 'text-center',
                            ],
                            'filter' => Html::activeTextInput($searchModel, 'user_name', [
                                'class' => 'form-control', 'id' => null
                            ]),
                            'label' => '用户',
                        ],


                        [
                            'attribute' => 'is_active',
                            'contentOptions' => [
                                'class' => 'center',
                            ],
                            'value'=>function($model){
                                return \app\models\CardModel::getActive()[$model->is_active];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'is_active', \app\models\CardModel::getActiveAll(), ['class' => 'form-control']),
                        ],
                        [
                            'attribute' => 'is_useable',
                            'contentOptions' => [
                                'class' => 'center',
                            ],
                            'value'=>function($model){
                                return \app\models\CardModel::getUseable()[$model->is_useable];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'is_useable', \app\models\CardModel::getUseableAll(), ['class' => 'form-control']),
                        ],
                        [
                            'attribute' => 'is_used',
                            'contentOptions' => [
                                'class' => 'center',
                            ],
                            'value'=>function($model){
                                return \app\models\CardModel::getUsed()[$model->is_used];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'is_used', \app\models\CardModel::getUsedAll(), ['class' => 'form-control']),
                        ],
                        [
                            'attribute' => 'is_cancel',
                            'contentOptions' => [
                                'class' => 'center',
                            ],
                            'value'=>function($model){
                                return \app\models\CardModel::getCancel()[$model->is_cancel];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'is_cancel', \app\models\CardModel::getCancelAll(), ['class' => 'form-control']),
                        ],
                        [
                            'attribute' => 'status',
                            'contentOptions' => [
                                'class' => 'center',
                            ],
                            'format'=>'raw',
                            'value'=>function($model){
                                return \app\models\CardModel::getStatus()[$model->status];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', \app\models\CardModel::getStatusAll(), ['class' => 'form-control']),
                        ],
                        'expired_at:datetime',

                    ],
                ]);
                ?>
            </div>
        </div>
    </section>
    <!-- page end-->
</section>