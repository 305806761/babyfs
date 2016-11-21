<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午2:30
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