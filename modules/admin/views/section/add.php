<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课程阶段添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css"/>
<style>
    .tdleft {
        font-size: 20px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: right;
        vertical-align: top;
        width: 30%;
    }

    ul {
        list-style-type: none;
    }

    .liShow {
        display: block;
        background: while;
    }

    .liHide {
        display: none;
        background: blue;
    }

</style>
<script>

    var nextState = 1;
    function change(obj) {
        var liArray = document.getElementsByTagName("dd");
        //var liArray = $('.li');
        var i = 1;
        var length = liArray.length;
        switch (nextState) {
            case 1:
                obj.innerHTML = "当前选择↑";
                for (; i < length; i++) {
                    liArray[i].className = "liShow";
                }
                nextState = 0;
                break;
            case 0:
                obj.innerHTML = "当前选择↓";
                for (; i < length; i++) {
                    liArray[i].className = "liHide";
                }
                nextState = 1;
        }
    }

</script>
<form action="/admin/section/add" method="post" enctype="multipart/form-data">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">所在课程:</td>
            <td>

                <dl id="myUl">
                    <dd class="liMenu" onclick="change(this);">当前选择↓</dd>
                    <?php foreach ($course as $key => $value): ?>
                        <dd value="1" class="liHide">
                        <input type="checkbox" name="course_id[]" value="<?= $value['course_id'] ?>"
                        <?php if ($value['checked']) echo checked ?> />
                        <?= $value['name'] ?>
                        </dd>
                    <?php endforeach; ?>
                </dl>
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段名称:</td>
            <td>
                <input type="text" name="name" value="<?= $section['name'] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">课程阶段编号:</td>
            <td>
                <input type="text" name="code" value="<?= $section['code'] ?>"/>

            </td>
        </tr>
        <tr>
            <td class="tdleft">上传课程阶段图片:</td>
            <td>
                <img src="<?= json_decode($section['image']) ?>" width="120" height="auto"/>
                <input type="file" name="image" size="35"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">有赞购买链接:</td>
            <td>
                <input type="text" name="buyurl" value="<?= $section['buyurl'] ?>" size="35"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">阶段有效期</td>
            <td>
                <input id="expire_time" type="text" readonly="readonly" size="12" name="expire_time"
                       value="<?= $section['expire_time'] ?>"/>
                <input id="selbtn1" class="button" type="button" value="选择"
                       onclick="return showCalendar('expire_time', '%Y-%m-%d', false, false, 'selbtn1');"
                       name="selbtn1">

            </td>
        </tr>
        <tr>
            <td class="tdleft">阶段开课时间</td>
            <td>
                <input id="create_time" type="text" readonly="readonly" size="12" name="create_time"
                       value="<?= $section['create_time'] ?>"/>
                <input id="selbtn1" class="button" type="button" value="选择"
                       onclick="return showCalendar('create_time', '%Y-%m-%d', false, false, 'selbtn1');"
                       name="selbtn1">

            </td>
        </tr>
        <tr>
            <td class="tdleft">课程排序:</td>
            <td>
                <input type="text" name="sort" value="<?= $section['sort'] ?>"/>
            </td>
        </tr>
        <tr>
            <td class="tdleft">是否显示（0显示，1不显示）</td>
            <td>
                <select name="is_show">
                    <option value="0" <?php if($section['is_show'] == 0) echo " selected"?>>显示</option>
                    <option value="1" <?php if($section['is_show'] == 1) echo " selected"?>>不显示</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="hidden" name="section_id" value="<?= $section['section_id'] ?>">
                <input type="submit" class="tdsubmit" value="提交"/>

            </td>
        </tr>
    </table>


</form>
