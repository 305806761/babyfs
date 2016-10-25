<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '课件生成';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css">
<link href="/css/pc_qipao.css" rel="stylesheet" type="text/css">
<link href="/css/temp.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.min.js"></script>
<script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.jplayer.min.js"></script>
<link >
<style>
    .tdleft{
        font-size:20px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: right;
        vertical-align: top;
        width: 30%;
            }

</style>
<form action="index.php?r=template/add-temp" method="post">
    <table width="100%" align="center">
        <tr>
            <td class="tdleft">课程列表</td>
            <td>



                    <?php foreach ($course as $key => $value): ?>

                       <input type="checkbox" name="course_id" value="<?= $value['course_id'] ?>"> <?= $value['name']?><br />
                    <?php endforeach; ?>



            </td>
        </tr>
        <tr>
            <td class="tdleft">课件名称:</td>
            <td>
                <input type="text" name="title" />
            </td>
        </tr>
        <tr>
            <td class="tdleft">课件简介:</td>
            <td>
                <textarea name="small_text"></textarea>
            </td>
        </tr>

        <tr>
            <td><textarea></textarea></td>
        </tr>
        <tr>
            <td class="tdleft">课件内容:</td>
            <td>
            <ul>
                <?php foreach ($template as $key=>$value): ?>
                    <li class="licss"><a class="js-new-field" data-field-type="<?= $key ?>"><?= $value?></a></li>
                <?php endforeach; ?>
            </ul>
            </td>
        </tr>


        <tr>
            <td class="tdleft"></td>
            <td>
                <input type="submit" class="tdsubmit" value="提交" />
            </td>
        </tr>
    </table>



</form>
