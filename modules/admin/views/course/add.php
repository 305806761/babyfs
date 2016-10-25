<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程添加';
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
<form action="index.php?r=course/add" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">课程名称:</td>
            <td>
                <input type="text" name="name" />
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程编号:</td>
            <td>
                <input type="text" name="code" />

            </td>
        </tr>
        <tr>
            <td class="tdleft">查看课件的时间:</td>
            <td>
                <input type="text" name="class_hour" />

            </td>
        </tr>
        <tr>
            <td class="tdleft">课程是否免费:</td>
            <td>
                <select name="is_free">
                    <option value="0">免费课程</option>
                    <option value="1">收费课程</option>
                </select>

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
