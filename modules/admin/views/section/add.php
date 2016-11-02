<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程阶段添加';
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
<form action="/admin/section/add" method="post" enctype="multipart/form-data">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">所在课程:</td>
            <td>
                <select name="course_id">
                    <?php foreach($course as $key=>$value): ?>
                    <option <?php if($section['course_id'] == $value['course_id'] ) echo selected ?> value="<?=$value['course_id']?>"><?=$value['name']?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段名称:</td>
            <td>
                <input type="text" name="name" value="<?= $section['name']?>"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段编号:</td>
            <td>
                <input type="text" name="code" value="<?= $section['code']?>" />

            </td>
        </tr>
        <tr>
            <td class="tdleft">上传课程阶段图片:</td>
            <td>
                <img src="<?= json_decode($section['image'])?>" width="120" height="auto" />
                <input type="file" name="image"  size="35" />
            </td>
        </tr>
        <tr>
            <td class="tdleft">阶段有效期</td>
            <td>
                <input id="expire_time" type="text" readonly="readonly"  size="12" name="expire_time" value="<?= $section['expire_time']?>" />
                <input id="selbtn1" class="button" type="button" value="选择" onclick="return showCalendar('expire_time', '%Y-%m-%d', false, false, 'selbtn1');" name="selbtn1">

            </td>
        </tr>
        <tr>
            <td class="tdleft">课程排序:</td>
            <td>
               <input type="text" name="sort" value="<?= $section['sort']?>"  />
            </td>
        </tr>
        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="section_id" value="<?=$section['section_id']?>">
                <input type="submit" class="tdsubmit" value="提交" />

            </td>
        </tr>
    </table>



</form>
