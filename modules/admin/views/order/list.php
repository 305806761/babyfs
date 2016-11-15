<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 */
use yii\widgets\LinkPager;
$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/calendar/calendar.php"></script>
<link href="/calendar/calendar.css" rel="stylesheet" type="text/css"/>
<style>
    .tdleft {
        font-size: 12px;
        font-weight: bold;
        padding: 5px 1em;
        text-align: left;
        vertical-align: top;
        width: 25%;
    }
</style>

<table align="center">
    <form action="" method="post" onsubmit="confirm('确认要操作?')">
        <tr>
            <td>手机号：</td>
            <td><input type="text" name="mobile" /></td>
            <td>订单号：</td>
            <td><input type="text" name="order_sn" /></td>
            <td><input type="submit" value="查询" /></td>
        </tr>
    </form>
</table>

<table width="100%" align="center" border="1">

    <?php foreach ($orders['order'] as $key => $value): ?>
        <tr>
            <td class="tdleft">订单id：<?= $value['order_id'] ?></td>
            <td class="tdleft">订单号：<?= $value['order_sn'] ?></td>
            <td class="tdleft">手机号：<?= $value['mobile'] ?></td>
            <td class="tdleft">用户id：<?= $value['user_id'] ?></td>
            <td class="tdleft">订单状态：<?= $value['order_status'] .'/'. $value['refund_state']?></td>
        </tr>

        <?php if ($value['goods']): ?>
            <tr>
                <td colspan="5">
                    <table>
                        <?php foreach ($value['goods'] as $k => $val): ?>
                            <tr>
                                <td class="tdleft">
                                    商品code：<?= $val['code'] ?>
                                </td>
                                <td class="tdleft">
                                    商品名称：<?= $val['goods_name'] ?>
                                </td>
                                <td class="tdleft">
                                    数量：<?= $val['goods_number'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endif; ?>

    <?php endforeach; ?>
    <tr>
        <td colspan="5">
            <span class="epages"><?= LinkPager::widget(['pagination' => $orders['page']]) ?></span>
        </td>
    </tr>
</table>

