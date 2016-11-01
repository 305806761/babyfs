<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程阶段分类添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css" />
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
<form action="/admin/section/add-cat" method="post">
    <table width="100%" align="center">

        <tr>
            <td class="tdleft">分类名称:</td>
            <td>
                <input type="text" name="cat_name" value="<?= $cat['cat_name']?>" />
            </td>
        </tr>

        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="section_id" value="<?=$section_id?>">
                <input type="hidden" name="id" value="<?=$cat['id']?>">
                <input type="submit" class="tdsubmit" value="提交" />

            </td>
        </tr>
    </table>



</form>
