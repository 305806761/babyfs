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
<form action="" method="post" enctype="multipart/form-data">
    <table width="100%" align="center">

        <tr>
            <td class="tdleft">分类名称:</td>
            <td>
                <input type="text" name="SectionCat[cat_name]" value="<?= $model->cat_name ?>" />
            </td>
        </tr>

        <tr>
            <td class="tdleft">上传阶段分组图片:</td>
            <td>
                <img src="<?= json_decode( $model->image ) ?>" width="120" height="auto"/>
                <input type="file" name="SectionCat[image]" size="35"/>
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
