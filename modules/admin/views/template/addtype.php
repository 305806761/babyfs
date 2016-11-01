<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '模板类型添加';
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

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
<form action="/admin/template/add-tpye" name="theForm" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">模板类型:</td>
            <td>
                <input type="text" name="type" size="30" />
            </td>
        </tr>
        <tr>
            <td class="tdleft">模板参数及数据类型:</td>
            <td>
                <select name="param">
                    <?php foreach ($param as $value):?>
                    <option value="<?=$value?>"><?=$value?></option>
                    <?php endforeach;?>
                </select>
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
