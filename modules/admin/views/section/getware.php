<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 *
 * @var $this yii\web\View
 */

use yii\jui\Sortable;

$this->title = '获取课件';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
    $( function() {
        $( "#template_params, #template_params1" ).sortable({
            connectWith: ".ui-sortable"
        }).disableSelection();
    } );
');
?>

<div class="row">
    <div class="col-md-6">
        <?php
        echo Sortable::widget([
            'items' => ['a', 'b', 'c'],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'template_params',
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo Sortable::widget([
            'items' => ['e', 'f', 'g'],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'template_params1',
        ]);
        ?>
    </div>
</div>
