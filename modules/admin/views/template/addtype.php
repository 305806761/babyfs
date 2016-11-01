<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 *
 * @var $template array
 */

use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

$this->title = '模板类型添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tdleft {
        font-size: 20px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: right;
        vertical-align: top;
        width: 30%;

    }

</style>
<form action="" name="theForm" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">模板类型:</td>
            <td>
                <input type="text" name="type" value="<?= $template['type'] ?>" size="30"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">模板参数及数据类型:</td>
            <td>
                <?php
                $p = json_decode($template['param'], true);
                $i = 0;
                ?>

                <?php if ($p): ?>
                    <?php foreach ($p as $name => $type): ?>
                        <div class="row">
                            <input type="text" name="param[<?= $i ?>][name]" value="<?= $name ?>"/>
                            <?= Html::dropDownList("param[$i][type]", $type, Yii::$app->params['template_types']) ?>
                        </div>
                        <?php $i++; endforeach; ?>
                <?php endif ?>

                <?php for (; $i < 10; $i++): ?>
                    <div class="row">
                        <input type="text" name="param[<?= $i ?>][name]" value=""/>
                        <?= Html::dropDownList("param[$i][type]", null, Yii::$app->params['template_types']) ?>
                    </div>
                <?php endfor; ?>

            </td>
        </tr>

        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="template_id" value="<?= $template['template_id'] ?>"/>
                <input type="submit" class="tdsubmit" value="提交"/>

            </td>
        </tr>
    </table>
</form>
