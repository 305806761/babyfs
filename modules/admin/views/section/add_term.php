<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '阶段学期添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css"/>
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

<form action="" method="post">
    <table width="100%" align="center">

        <tr>
            <td class="tdleft">所在阶段</td>
            <td><?= $section->name?></td>
        </tr>

        <tr>
            <td class="tdleft">学期</td>
            <td><input type="text" name="term" /></td>
        </tr>

        <tr>
            <td class="tdleft">阶段开课时间</td>
            <td>
                <input id="create_time" type="text" readonly="readonly" size="12" name="create_time"
                       value=""/>
                <input id="selbtn1" class="button" type="button" value="选择"
                       onclick="return showCalendar('create_time', '%Y-%m-%d', false, false, 'selbtn1');"
                       name="selbtn1">

            </td>
        </tr>

        <tr>
            <td class="tdleft">截至日期</td>
            <td>
                <input id="expire_time" type="text" readonly="readonly" size="12" name="expire_time"
                       value=""/>
                <input id="selbtn1" class="button" type="button" value="选择"
                       onclick="return showCalendar('expire_time', '%Y-%m-%d', false, false, 'selbtn1');"
                       name="selbtn1">

            </td>
        </tr>

        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="section_id" value="<?= $section->section_id ?>">
                <input type="submit" class="tdsubmit" value="提交"/>

            </td>
        </tr>
    </table>
</form>
