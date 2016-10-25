<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '模板添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tdleft{
        font-size:20px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: right;
        vertical-align: top;
        width: 30%;

    }

</style>
<form action="index.php?r=template/add-temp-do" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">模板类型:</td>
            <td>
                <select name="template_id">

                    <option value="" checked>请选择模板类型</option>
                    <?php foreach ($temp as $key =>$temp): ?>
                        <option value="<?= $key ?>"><?= $temp?></option>
                    <?php endforeach; ?>

                </select>

            </td>
        </tr>
        <tr>
            <td class="tdleft">模板html:</td>
            <td>
                <textarea name="code"></textarea>

            </td>
        </tr>
        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="submit" class="tdsubmit" value="提交" />

            </td>
        </tr>
    </table>



</form>
