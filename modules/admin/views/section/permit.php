<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '会员添加权限';
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
</style>

<form action="" method="post" enctype="multipart/form-data">
    <table width="100%" align="center" border="1">
        <tr>
            <td colspan="2"><?= $user->phone ?></td>
        </tr>
        <?php foreach ($course_section as $key => $value): ?>
            <tr>
                <td>课程：<?= $value['name'] ?>
                </td>
                <?php if ($value['section']): ?>
                    <td>阶段：
                        <table>
                            <?php foreach ($value['section'] as $key => $val): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="course_section_id[]" value="<?= $value['course_id'].','.$val['section_id']?>"/>
<?= $val['name'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="user_id" value="<?= $user->user_id ?>">
                <input type="submit" class="tdsubmit" value="提交"/>
            </td>
        </tr>
    </table>


</form>
