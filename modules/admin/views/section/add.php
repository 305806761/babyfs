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
<form action="/admin/section/add" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">所在课程:</td>
            <td>
                <select name="course_id">
                    <?php foreach($course as $key=>$value): ?>
                    <option value="<?=$value['course_id']?>"><?=$value['name']?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段名称:</td>
            <td>
                <input type="text" name="name" />
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段编号:</td>
            <td>
                <input type="text" name="code" />

            </td>
        </tr>
        <tr>
            <td class="tdleft">阶段有效期</td>
            <td>
                <input type="text" name="class_hour" />

            </td>
        </tr>
        <tr>
            <td class="tdleft">课程排序:</td>
            <td>
               <input type="text" name="sort" />
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
