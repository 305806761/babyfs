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
            <td  class="tdleft">模板类型</td>
            <td  class="tdleft">模板参数</td>
            <td  class="tdleft">操作</td>
        </tr>
        <?php foreach($template as $key=>$value): ?>
            <tr>
                <td class="tdvleft"><?php echo $value['type']; ?></td>
                <td class="tdvleft"><?php echo $value['param']; ?></td>
                <td class="tdvleft"><a href="/admin/template/edit-temp?temp_code_id=<?= $value['temp_code_id']; ?>">修改</a></td>
            </tr>
        <?php endforeach; ?>


    </table>



</form>
