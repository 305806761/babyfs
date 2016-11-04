<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '修改会员';
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
<table align="center">
    <form action="" method="post" name="theForm">
        <tr>
            <td>手机号：</td>
            <td><input type="text" name="phone" value="<?= $user->phone ?>"/></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="password" value=""/></td>
        </tr>
        <tr>

            <td></td>
            <td><input type="submit" value="提交"/></td>
        </tr>
    </form>
</table>




