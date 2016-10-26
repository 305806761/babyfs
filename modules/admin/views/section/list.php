<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程阶段列表';
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
            <td  class="tdleft">课程id</td>
            <td  class="tdleft">课程名称</td>
            <td class="tdleft">课程编码</td>
            <td  class="tdleft">课程阶段id</td>
            <td  class="tdleft">课程阶段名称</td>
            <td  class="tdleft">课程阶段编码</td>
            <td  class="tdleft">课程阶段创建时间</td>
            <td class="tdleft">操作</td>
        </tr>
        <?php foreach($coursesection as $key=>$value): ?>
        <tr>
            <td class="tdvleft"><?php echo $value['section_course_id']; ?></td>
            <td class="tdvleft"><?php echo $value['course_name']; ?></td>
            <td class="tdvleft"><?php echo $value['course_code']; ?></td>
            <td class="tdvleft"><?php echo $value['section_id']; ?></td>
            <td class="tdvleft"><?php echo $value['section_name']; ?></td>
            <td class="tdvleft"><?php echo $value['section_code']; ?></td>
            <td class="tdvleft"><?php echo $value['section_create_time']; ?></td>
            <td class="tdvleft"><a href="/admin/ware/add/section_id/<?= $value['section_id']; ?>">添加课件</a></td>
        </tr>
        <?php endforeach; ?>


    </table>



</form>
