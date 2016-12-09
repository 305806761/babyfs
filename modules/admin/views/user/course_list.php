<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/30
 * Time: 下午6:54
 * @var $this
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '用户课程列表';
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
$this->registerJs('
    $(".gridview").on("click", function () {
        //注意这里的$("#grid")，要跟我们第一步设定的options id一致
        var keys = $("#grid").yiiGridView("getSelectedRows");
        console.log(keys);
        $.post("del-all?id="+keys); 
    });
');
?>

<div class="ware-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view', 'style' => 'overflow:auto', 'id' => 'grid'],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn', 'name' => 'id',],
            'id',
            ['label' => '阶段名称', 'attribute' => 'section_name', 'value' => 'section.name'],
            ['label' => '学期批次', 'attribute' => 'term', 'value' => 'term.term'],
            ['label' => '手机号', 'attribute' => 'phone', 'value' => 'user.phone'],
            'create_time',
            'expire_time',
            // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['course-del', 'id' => $key],
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
                            ['course-update', 'id' => $key],
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
    ]);
    ?>
    <?= Html::a('批量删除', "javascript:void(0);", ['class' => 'btn btn-success gridview']) ?>
</div>
