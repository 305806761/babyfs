<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/10/30
 * Time: 下午6:54

 * @var $this yii\web\View
 * @var $searchModel app\models\WareSearch
 * @var $dataProvider yii\data\ActiveDataProvider
*/

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '课件';
?>

<div class="ware-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建课件', ['add'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'ware_id',
            'title',
            'small_text',
//            'contents',
            'create_time',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update} {delete} {copy}',
                'contentOptions' => [
                    'class' => 'text-center',
                    'width' => 120,
                ],
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $key],
                            [
                                'title' => '预览',
                                'aria-label' => '预览',
                                'data-pjax' => '0',
                                'data-method'=>'post'
                            ]
                        );

                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            ['update', 'id' => $key],
                            [
                                'title' => '更新',
                                'aria-label' => '更新',
                                'data-pjax' => '0',
                                'data-method'=>'post'
                            ]
                        );

                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'id' => $key],
                            [
                                'data' => ['confirm' => '您确定要删除此项吗？',],
                                'title' => '删除',
                                'aria-label' => '删除',
                                'data-pjax' => '0',
                                'data-method'=>'post'
                            ]
                        );

                    },

                    'copy' => function($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-share"></span>',
                            ['copy', 'id' => $key],
                            [
                                'title' => '复制',
                                'aria-label' => '复制',
                                'data-pjax' => '0',
                                'data-method'=>'post',
                            ]
                        );

                    },
                ],
            ],



        ],
    ]); ?>
</div>
