<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '获取课件';
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
    <form action="/admin/section/get-ware" method="post" name="theForm">
        <tr>
            <td>课件名称：</td>
            <td><input type="text" name="title" value="<?=$title?>"/></td>
            <td><input type="submit" value="查询"/></td>
        </tr>
    </form>
</table>
<?php if ($ware):?>
<table width="100%" align="center">
    <form name="memberform" method="post" action="/admin/user/checked" onsubmit="return confirm('确认要操作?');">
        <tr>
            <td class="tdleft">课件id</td>
            <td class="tdleft">课件名称</td>
            <td class="tdleft">课件简介</td>
            <td class="tdleft">操作</td>
        </tr>
        <?php foreach ($ware as $value): ?>
            <tr id=user<?= $value->ware_id ?>>

                <td class="tdvleft"><?= $value->ware_id ?></td>
                <td class="tdvleft"><?= $value->title ?></td>
                <td class="tdvleft"><?= $value->small_text ?></td>
                <td>
                    <input type="checkbox" name="ware_id[]"  id="ware_id[]" value="<?= $value->ware_id ?>"
                           onclick="if(this.checked){user<?= $value->ware_id ?>.style.backgroundColor='#DBEAF5';}
                               else{user<?= $value->ware_id ?>.style.backgroundColor='';}">

                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="6" height="25">

                <input name="section_cat_id" type="hidden"  value="<?=$section_cat_id?>">
                <input name="enews" type="hidden" id="enews" value="DelMember_all">
                <input type="submit" name value="提交" onclick="document.memberform.enews.value='DoCheckMember_all';" />
                <input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)">全选
            </td>
        </tr>
    </form>
</table>
<?php endif;?>
<script>

    function selectsection() {
        var course_id = $('#course_id').val();
        $.ajax({
            type: "get",
            url: "/admin/section/get-section",
            data: "course_id=" + course_id,
            cache: false,
            dataType: "json",
            success: function (data) {
                var response = data;
                var section = $('#section_id');
                section.empty();
                for (var i = 0; i < response.length; i++) {
                    section.append("<option value='" + response[i]['section_id'] + "'>" + response[i]['name'] + "</option>");
                }
            }
        });
    }

    function CheckAll(form) {
        for (var i = 0; i < form.elements.length; i++) {
            var e = form.elements[i];
            if (e.name != 'chkall')
                e.checked = form.chkall.checked;
        }
    }

</script>



