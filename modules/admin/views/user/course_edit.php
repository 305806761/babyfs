<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
$this->title = '会员课程关联导入';
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

<form action="" method="post" enctype="multipart/form-data">
    <div class="main-div">
        <table  align="center">
            <tr>
                <td> 上传文件: </td>
                <td><input type="file" name="import_edit" value="" size="40" /> </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="button" name="Submit" value=" 确定 " />
                </td>
            </tr>
        </table>
    </div>
</form>


