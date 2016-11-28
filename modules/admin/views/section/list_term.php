<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午3:08
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


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
            <div class="adv-table editable-table ">
                <div class="clearfix">
                    <div class="btn-group">

                    </div>

                </div>
                <div class="space15"></div>
                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => [
                        'class' => 'table table-striped table-hover table-bordered',
                        'id' => 'editable-sample',
                    ],
                    'pager'=>array(              //通过pager设置样式   默认为CLinkPager
                        'prevPageLabel' => '首页',
//                            'firstPageLabel'=>'首页',  //first,last 在默认样式中为{display:none}及不显示，通过样式{display:inline}即可
                        'nextPageLabel' => '下一页',
//                            'lastPageLabel'=>'末页',
//                            'header'=>'',
                        'options'=>[
                            'class' => '',
//                            'style' => 'float: right;'
                        ],
                    ),
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
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'stage.name',
                            'contentOptions' => [
                                'class' => 'text-center',
                                'width' => 120,
                            ],
                            'label' => '阶段',
                        ],
                        'term',
                        'start_time:date',
                        'end_time:date',
                        'order_start_time:date',
                        'order_end_time:date',
                        'created_at:date',

                        [
                        'attribute' => 'status',
                        'contentOptions' => [
                            'class' => 'center',
                        ],
                        'format'=>'raw',
                        'value'=>function($model){
                            return Html::activeDropDownList($model, 'status', \app\models\TermModel::getStatus());
                        },

                    ],
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'delete' => function($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['delete-term', 'id' => $key],
                                        [
                                            'data' => ['confirm' => '您确定要删除此项吗？',],
                                            'title' => '删除',
                                            'aria-label' => '删除',
                                            'data-pjax' => '0',
                                            'data-method'=>'post'
                                        ]
                                    );

                                },

                                'update' => function($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['update-term', 'id' => $key],
                                        [
                                            'title' => '更新',
                                            'aria-label' => '更新',
                                            'data-pjax' => '0',
                                            'data-method'=>'post'
                                        ]
                                    );

                                },
                            ],
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </section>
    <!-- page end-->
</section>
