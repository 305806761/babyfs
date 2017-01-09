<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/30
 * Time: 下午6:54
 * @var $this
 * @var $searchModel app\models\search\CatSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '会员列表';
?>

<div class="ware-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $userdate,
        'filterModel' => $searchModel,
        'columns' => [
            //'user_id',
            ['label' => 'id', 'attribute' => 'user_id'],
            // ['label' => '学期批次', 'attribute' => 'term', 'value' => 'section_term.term'],
            'username',
            'email',
            'phone',
            'password',
            // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{add_permit}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            ['edit', 'user_id' => $key],
                            [
                                'title' => '更新',
                                'aria-label' => '更新',
//                                'data-pjax' => '0',
//                                'data-method' => 'get'
                            ]
                        );

                    },
                    'add_permit' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>',
                            ['section/add-permit', 'user_id' => $key],
                            [
                                'title' => '权限',
                                'aria-label' => '权限',
//                                'data-pjax' => '0',
//                                'data-method' => 'get'
                            ]
                        );

                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'user_id' => $key],
                            [
                                'data' => ['confirm' => '您确定要删除此项吗？',],
                                'title' => '删除',
                                'aria-label' => '删除',
                               // 'data-pjax' => '0',
                                //'data-method' => 'get'
                            ]
                        );

                    },


                ],
            ],
        ],


    ]); ?>
</div>



