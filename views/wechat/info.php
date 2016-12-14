<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 下午3:08
 */
use yii\helpers\Url;
$this->title = '用户信息';

?>
<div style=" width: 100%; margin:0 auto; text-align: center">

<div style="text-align: center">
    <img src="<?=$model->headimgurl;?>" width="150" height="100" />
</div>
<h1 style="text-align: center"><?=$model->nickname;?></h1>
<a href="<?=Url::toRoute('user/signup')?>" style="background-color: #00eebb;">去绑定手机号</a>

</div>