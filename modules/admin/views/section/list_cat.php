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

            <td  class="tdleft">课程阶段名称</td>
            <td  class="tdleft">课程阶段分组名称</td>
            <td class="tdleft">操作</td>
        </tr>
        <?php foreach($list_cat as $key=>$value): ?>
            <tr>

                <td class="tdvleft"><?= $value['section_name']; ?></td>
                <td class="tdvleft"><?= $value['cat_name']; ?></td>
                <td class="tdvleft">
                    <a href="<?= \yii\helpers\Url::to([
                        'section/get-ware',
                        "section_cat_id"=>$value['section_cat_id'],
                    ])?>">添加课件</a> |
                    <a href="<?= \yii\helpers\Url::to(['section/edit-cat', "id"=>$value['section_cat_id']])?>">修改</a>
                </td>

            </tr>
        <?php endforeach; ?>


    </table>
</form>
