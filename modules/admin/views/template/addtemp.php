<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '模板添加';
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

?>
<style>
    .tdleft {
        font-size: 20px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: right;
        vertical-align: top;
        width: 30%;

    }

</style>
<form action="/admin/template/add-temp" name="theForm" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">模板类型:</td>
            <td>
                <select name="template_id" id="template_id">

                    <?php foreach ($temp as $key => $temp): ?>
                        <option
                            value="<?= $key ?>" <?php if ($key == $tempcode[0]['template_id']): ?> selected="selected" <?php endif ?>><?= $temp['type'] ?>
                            | <?= $temp['param'] ?></option>

                    <?php endforeach; ?>

                </select>
            </td>
        </tr>
        <tr>
            <td class="tdleft">模板html:</td>
            <td>
                <textarea name="code"><?= Html::encode($tempcode[0]['code']) ?></textarea>

            </td>
        </tr>
        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="temp_code_id" value="<?= $tempcode[0]['temp_code_id'] ?>"/>
                <input type="submit" class="tdsubmit" value="提交"/>

            </td>
        </tr>
    </table>


</form>

<script>

    function rapidCatAdd() {
        var cat_div = document.getElementById("category_add");

        if (cat_div.style.display != '') {
            var cat = document.forms['theForm'].elements['addedCategoryName'];
            cat.value = '';
            cat_div.style.display = '';
        }
    }

    function addCategory() {
        var cat = document.forms['theForm'].elements['addedCategoryName'];
        if (cat.value.replace(/^\s+|\s+$/g, '') == '') {
            alert(category_cat_not_null);
            return;
        }
        $.ajax({
            type: "get",
            url: "/admin/template/add-type",
            data: "type=" + cat.value,
            cache: false,
            dataType: "json",
            success: function (result) {
                if (result.error) {
                    alert('添加模板类型失败');
                }

                var response = result;
                var section = $("#template_id");
                section.empty();
                section.append("<option value='" + response['id'] + "'>" + response['type'] + "</option>");
            }
        });
    }

    function hideCatDiv() {
        var category_add_div = document.getElementById("category_add");
        if (category_add_div.style.display != null) {
            category_add_div.style.display = 'none';
        }
    }

</script>
