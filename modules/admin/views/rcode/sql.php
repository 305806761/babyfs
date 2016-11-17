<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '生成课件二维码';
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
    <form action="<?=\yii\helpers\Url::to('sql')?>" method="post" name="theForm">
        <tr>
            <td>sql语句：</td>
            <td><textarea name="sql"></textarea></td>
        </tr>
        <tr><td colspan="2"> <td><input type="submit" value="修改"/></td></td></tr>
    </form>
</table>





