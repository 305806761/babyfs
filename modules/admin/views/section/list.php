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

            <td  class="tdleft">课程阶段id</td>
            <td  class="tdleft">课程阶段名称</td>
            <td  class="tdleft">课程阶段编码</td>
            <td  class="tdleft">课程阶段有效期</td>
            <td  class="tdleft">顺序</td>
            <td  class="tdleft">有赞购买链接</td>
            <td class="tdleft">操作</td>
        </tr>
        <?php foreach($coursesection as $key=>$value): ?>
        <tr>
            <td class="tdvleft"><?php echo $value['section_id']; ?></td>
            <td class="tdvleft"><?php echo $value['name']; ?></td>
            <td class="tdvleft"><?php echo $value['code']; ?></td>
            <td class="tdvleft"><?php echo $value['expire_time']; ?></td>
            <td class="tdvleft"><?php echo $value['sort']; ?></td>
            <td class="tdvleft"><?php echo $value['buyurl']; ?></td>
            <td class="tdvleft">
                <a href="/admin/section/edit-section/?section_id=<?= $value['section_id']; ?>">修改</a> |
                <a href="/admin/section/add-cat?section_id=<?= $value['section_id']; ?>">加分组</a> |
                <a href="/admin/section/add-term?section_id=<?= $value['section_id']; ?>">加学期</a>
            </td>

        </tr>
        <?php endforeach; ?>


    </table>



</form>
