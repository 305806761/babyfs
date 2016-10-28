<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '会员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tdvleft {
        font-size: 12px;
        padding: 5px 1em;
        text-align: left;
        vertical-align: top;
        width: auto;

    }

    .tdleft {
        font-size: 20px;
        font-weight: bold;
        text-align: left;

    }
</style>
<form action="/admin/user/search" method="post" name="theForm">
    <table>
        <tr>
            <td>手机号：</td>
            <td><input type="text" name="phone" /></td>
            <td>
                <select name="course_id" id="course_id" onchange="selectsection()">
                    <option value="no" checked>请选择课程</option>
                    <?php foreach ($course as $key => $value): ?>
                        <option value="<?= $value['course_id'] ?>"><?= $value['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="section_id" id="section_id">
                    <option value="no" checked>请选择课程阶段</option>
                </select>
            </td>
            <td><input type="submit" value="查询"/></td>
        </tr>
    </table>
</form>
<table width="100%" align="center">
    <tr>
        <td  class="tdleft">课程</td>
        <td  class="tdleft">课程阶段</td>
        <td  class="tdleft">手机号</td>
        <td  class="tdleft">注册时间</td>
        <td  class="tdleft">开课时间</td>
        <td  class="tdleft">结束时间</td>
        <!--td  class="tdleft">操作</td-->
    </tr>
    <?php foreach($user_course as $value): ?>
        <tr>
            <td class="tdvleft"><?= $value['course_name']; ?></td>
            <td class="tdvleft"><?= $value['section_name']; ?></td>
            <td class="tdvleft"><?= $value['phone']; ?></td>
            <td class="tdvleft"><?= $value['user_created']; ?></td>
            <td class="tdvleft"><?= $value['create_time']; ?></td>
            <td class="tdvleft"><?= $value['expire_time']; ?></td>
            <!--td class="tdvleft"><a href="/admin/template/edit-temp?temp_code_id=<?= $value['temp_code_id']; ?>">修改</a></td-->
        </tr>
    <?php endforeach; ?>


</table>
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

</script>



