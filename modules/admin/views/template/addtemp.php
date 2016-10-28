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

                        <option <?php if ($key = $tempcode['template_id']): ?> checked <?php endif ?>
                            value="<?= $key ?>"><?= $temp ?></option>

                    <?php endforeach; ?>

                </select>

                <a href="javascript:void(0)" onclick="rapidCatAdd()" title="添加类型" class="special">添加类型</a>
                <span id="category_add" style="display:none;">
               <input class="text" size="10" name="addedCategoryName"/>
               <a href="javascript:void(0)" onclick="addCategory()" title="确定" class="special">确定</a>
                    <!--a href="javascript:void(0)" onclick="return goCatPage()" title="分类管理" class="special" >分类管理</a-->
               <a href="javascript:void(0)" onclick="hideCatDiv()" title="隐藏" class="special"><<</a>
               </span>


            </td>
        </tr>
        <tr>
            <td class="tdleft">模板html:</td>
            <td>
                <textarea name="code"><?= Html::encode($tempcode['code']) ?></textarea>

            </td>
        </tr>
        <tr>
            <td class="tdleft"></td>
            <td>
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
                if(result.error){ alert('添加模板类型失败');}

                var response = result;
                var section = $('#template_id');
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
