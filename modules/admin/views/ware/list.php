<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/10/30
 * Time: 下午6:54
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
