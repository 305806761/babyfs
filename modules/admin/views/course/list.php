<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tdvleft{
        font-size:12px;
        padding: 5px 1em;
        text-align: left;
        vertical-align: top;
        width: auto;

    }

    .tdleft{
        font-size:20px;
        font-weight: bold;
        text-align: left;


    }
</style>
<form action="index.php?r=course/add" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">课程id</td>
            <td class="tdleft">课程名称</td>
            <td class="tdleft">课程编码</td>
            <td class="tdleft">查看课件多少天</td>

            <td class="tdleft">操作</td>
        </tr>
        <?php foreach($course as $key=>$value): ?>
        <tr>
            <td class="tdvleft"><?php echo $value['course_id']; ?></td>
            <td class="tdvleft"><?php echo $value['name']; ?></td>
            <td class="tdvleft"><?php echo $value['code']; ?></td>
            <td class="tdvleft"><?php echo $value['class_hour']; ?></td>
            <td class="tdvleft"><a href="/admin/course/edit?course_id=<?= $value['course_id']; ?>">修改</a></td>
        </tr>
        <?php endforeach; ?>


    </table>



</form>
