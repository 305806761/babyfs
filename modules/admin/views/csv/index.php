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
/* @var $searchModel backend\models\searchs\CategorySearchModel */


$this->title = "列表";
$this->params['breadcrumbs'][] = $this->title;
$userId = intval(Yii::$app->request->get('id'));

?>
<section class="wrapper site-min-height">
    <!-- page start-->
    <section class="panel">
        <header class="panel-heading">
            <?=$this->title?>
        </header>
        <div class="panel-body">
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
                            'attribute' => 'category_name',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'attribute' => 'subcategory_name',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'attribute' => 'title',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'attribute' => 'code',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'label' => '课程名称',
                            'attribute' => 'course.name',
                            'filter' => Html::activeTextInput($searchModel, 'course_name', [
                                'class' => 'form-control', 'id' => null
                            ]),
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute' => 'alone_money',
                            'headerOptions' => ['width' => '100'],
                        ],

                        [
                            'attribute' => 'all_money',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute' => 'my_money',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute' => 'surplus_money',
                            'headerOptions' => ['width' => '100'],
                        ],

                        'order_add_time:datetime',
                        'number',

                    ],
                ]);
                ?>
            </div>
        </div>
    </section>
    <!-- page end-->
</section>