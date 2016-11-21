<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/20
 * Time: 下午11:17
 */
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
$this->title = "新增";
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css"/><section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'section' => $section,
    ]);
    ?>
</section>