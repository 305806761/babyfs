<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/15
 * Time: 上午10:16
 */

$this->title = "激活";
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('activate_form', [
        'model' => $model,
        'items' => $items,
    ]);
    ?>
</section>