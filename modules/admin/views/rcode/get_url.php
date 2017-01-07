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
    <form action="<?=\yii\helpers\Url::to('get-free-url')?>" method="post" name="theForm">
        <tr>
            <td>免费课section_id：</td>
            <td><input type="text" name="section_id" /></td>
        </tr>
        <tr>
            <td>免费课学期id：</td>
            <td><input type="text" name="term_id" /></td>
        </tr>
        <tr>
            <td>免费课学期结束时间：</td>
            <td><input type="text" name="time" /></td>
        </tr>
        <tr><td colspan="2"> <td><input type="submit" value="生成"/></td></td></tr>
    </form>
</table>





