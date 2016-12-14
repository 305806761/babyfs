<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午4:59
 */

$this->title = "新增";
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</section>