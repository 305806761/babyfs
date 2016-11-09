<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '会员列表';
$this->params['breadcrumbs'][] = $this->title;
use yii\widgets\LinkPager;

?>
<style>
    .tdvleft {
        font-size: 12px;
        padding: 5px 1em;
        text-align: left;
        vertical-align: top;
        width: auto;

    }

    .epages {
        font: 11px/12px Tahoma;
        margin: 3px 0;
    }

    .tdleft {
        font-size: 20px;
        font-weight: bold;
        text-align: left;

    }
</style>
<table  align="center">
    <form action="/admin/user/user-search" method="post" name="theForm">
        <tr>
            <td>手机号：</td>
            <td><input type="text" name="phone" value="<?=$phone?>"/></td>
            <td><input type="submit" value="查询"/></td>
        </tr>
    </form>
</table>

<table width="100%" align="center">
    <form name="memberform" method="post" action="/admin/user/checked" onsubmit="return confirm('确认要操作?');">
        <tr>
            <td class="tdleft">用户id</td>
            <td class="tdleft">手机号</td>
            <td class="tdleft">注册时间</td>
            <td class="tdleft">操作</td>
        </tr>
        <?php foreach ($users as $value): ?>
            <tr id=user<?= $value['user_id'] ?>>
                <td class="tdvleft"><?= $value['user_id']; ?></td>
                <td class="tdvleft"><?= $value['phone']; ?></td>
                <td class="tdvleft"><?= $value['created']; ?></td>

                <td>
                    <a href="<?= \yii\helpers\Url::to(['user/edit',"user_id"=>$value['user_id']])?>">修改</a> |
                    <a href="<?= \yii\helpers\Url::to(['section/add-permit',"user_id"=>$value['user_id']])?>">权限</a> |
                    <input type="checkbox" name="id[]"  id="id[]" value="<?= $value['user_id'] ?>"
                           onclick="if(this.checked){user<?= $value['user_id'] ?>.style.backgroundColor='#DBEAF5';}
                               else{user<?= $value['user_id'] ?>.style.backgroundColor='';}">
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="6" height="25">
                <span class="epages"><?= LinkPager::widget(['pagination' => $pagination]) ?></span>
                <input name="enews" type="hidden" id="enews" value="DelMember_all">
                <input type="submit" name value="删除" onclick="document.memberform.enews.value='DoCheckMember_all';" />
                <input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)">全选
            </td>
        </tr>
    </form>
</table>
<script>
    function CheckAll(form) {
        for (var i = 0; i < form.elements.length; i++) {
            var e = form.elements[i];
            if (e.name != 'chkall')
                e.checked = form.chkall.checked;
        }
    }

</script>



