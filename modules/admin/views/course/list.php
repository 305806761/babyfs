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

$this->title = '课程列表';
?>

<div class="ware-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $course,
        'filterModel' => $searchModel,
        'columns' => [
            'course_id',
            //['label' => '阶段名称', 'attribute' => 'section_name', 'value' => 'section.name'],
           // ['label' => '学期批次', 'attribute' => 'term', 'value' => 'section_term.term'],
            'name',
            'code',
            'type',
            'price',
            // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'course_id' => $key],
                            [
                                'data' => ['confirm' => '您确定要删除此项吗？',],
                                'title' => '删除',
                                'aria-label' => '删除',
                                'data-pjax' => '0',
                                'data-method' => 'post'
                            ]
                        );

                    },

                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            ['edit', 'course_id' => $key],
                            [
                                'title' => '更新',
                                'aria-label' => '更新',
                                'data-pjax' => '0',
                                'data-method' => 'post'
                            ]
                        );

                    },
                ],
            ],
        ],


    ]); ?>
</div>
