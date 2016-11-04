<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '生成课件二维码';
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
    <form action="<?=\yii\helpers\Url::to('get-qrcode')?>" method="post" name="theForm">
        <tr>
            <td>生成二维码：</td>
            <td><input type="text" name="url" /></td>
            <td><input type="submit" value="生成"/></td>
        </tr>
    </form>
</table>





