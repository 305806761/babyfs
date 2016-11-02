<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;

$this->title = $ware['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<header>
    <div class="introduce1-top">
        <h2>Lesson <?= $ware['ware_id']?></h2>
        <h1><?= $ware['title']?></h1>
    </div>
</header>
<div class="C-con-dialogue clearfix">
    <div class="introduce2-center">
    <?= $ware['contents']?>


    <!--div class="C-dialogue-title">
        <h1>课程目标</h1>
        <h2>看看今天的重点是什么</h2>
    </div>
    <div class="C-left-dialogue clearfix">
        <div class="C-left-dialogue-img"></div>
        <div class="C-left-dialogue-content">
            <dl class="clearfix">
                <dt>1</dt>
                <dd>
                    <p>是这些童谣真的就很悦耳，很上口。 流传这么多年不是白流传的。</p>
                </dd>
            </dl>
            <dl class="clearfix">
                <dt>2</dt>
                <dd>
                    <p>是这些童谣，就像我们从小听着长大的童谣一样，有深深的文化的烙印。</p>
                </dd>
            </dl>
        </div>
    </div>
    <div class="C-dialogue-title">
        <h1>文化背景</h1>
        <h2>看看今天的重点是什么</h2>
    </div>
    <div class="C-left-dialogue clearfix">
        <div class="C-left-dialogue-img"></div>
        <div class="C-left-dialogue-content">
            <h1>Hickory Dickory Dock最早在1744年就已经问世了，是一首家喻户晓的童谣。</h1>
            <h2>让宝宝从小就听经典童谣是非常有意义的：</h2>
            <dl class="clearfix">
                <dt>1</dt>
                <dd>
                    <p>是这些童谣真的就很悦耳，很上口。 流传这么多年不是白流传的。</p>
                </dd>
            </dl>
            <dl class="clearfix">
                <dt>2</dt>
                <dd>
                    <p>是这些童谣，就像我们从小听着长大的童谣一样，有深深的文化的烙印。</p>
                </dd>
            </dl>
            <dl class="clearfix">
                <dt>3</dt>
                <dd>
                    <p>是很多的童谣都有对应的互动游戏可以玩。</p>
                </dd>
            </dl>
        </div>
    </div>
    <div class="C-dialogue-title">
        <h1>视频讲解</h1>
        <h2>看看今天的重点是什么</h2>
    </div-->
        </div>
</div>