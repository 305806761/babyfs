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
        width: 30%;

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
            <td width="5%" class="tdleft">课程id</td>
            <td width="30%" class="tdleft">课程名称</td>
            <td width="5%" class="tdleft">课程编码</td>
            <td width="20%" class="tdleft">查看课件多少天</td>
            <td width="20%" class="tdleft">是否免费（0免费1收费）</td>
        </tr>
        <?php foreach($course as $key=>$value): ?>
        <tr>
            <td class="tdvleft"><?php echo $value['course_id']; ?></td>
            <td class="tdvleft"><?php echo $value['name']; ?></td>
            <td class="tdvleft"><?php echo $value['code']; ?></td>
            <td class="tdvleft"><?php echo $value['class_hour']; ?></td>
            <td class="tdvleft"><?php echo $value['is_free']; ?></td>
        </tr>
        <?php endforeach; ?>


    </table>



</form>
