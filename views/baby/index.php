<?php

use yii\helpers\Url;
use yii\web\View;


$this->title = "宝宝英语能力评估";

$this->registerCssFile('/default/baby/css/global.css');
$this->registerCssFile('/default/baby/css/LArea.css');
$this->registerCssFile('/default/baby/css/index.css');
$this->registerCssFile('/default/baby/css/swiper.min.css');
$this->registerCssFile('/default/baby/css/animate.min.css');


$this->registerJsFile('/default/baby/js/jquery-1.10.1.min.js');
$this->registerJsFile('/default/baby/js/swiper.min.js');
$this->registerJsFile('/default/baby/js/LAreaData1.js');
$this->registerJsFile('/default/baby/js/LAreaData2.js');
$this->registerJsFile('/default/baby/js/LArea.js');
$this->registerJsFile('/default/baby/js/index.js');



$js = <<<JS
    var phoneWidth = parseInt(window.screen.width);
    var phoneScale = phoneWidth/640;
    var ua = navigator.userAgent;
    if (/Android (\d+\.\d+)/.test(ua)){
        var version = parseFloat(RegExp.$1);
        if(version>2.3){
            document.write('<meta name=\"viewport\" content=\"width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi\">');
        }else{
            document.write('<meta name=\"viewport\" content=\"width=640, target-densitydpi=device-dpi\">');
        }
    } else {
        document.write('<meta name=\"viewport\" content=\"width=640, user-scalable=no, target-densitydpi=device-dpi\">');
    }
    

    
    
JS;
$this->registerjs($js, View::POS_HEAD);


?>

<section class="swiper-container">
  <div class="swiper-wrapper">
    <!-- page0 -->
    <article class="swiper-slide swiper-slide1" data-hash="page1">
      <p class="p0Title"></p>
      <div class="p0Img">
        <p class="p0Img2"></p>
        <p class="p0Img1"></p>
      </div>
      <!-- 宝宝信息 -->
      <div class="babyMassage">
        <div class="p0Text1Bg"></div>
        <input id="userid" type="hidden" value=""/>
        <div class="p0Text1">
          <p class="p0Select1ClickBtn" id="p0Select1ClickBtn" title="选择" page0-data-num="0">选择</p>
          <ul class="p0Select1" id="p0Select1">
            <li page0-data-num="1">0-2岁（不包含2岁）</li>
            <li page0-data-num="2">2-4岁（不包含4岁）</li>
            <li page0-data-num="3">4-6岁（包含6岁）</li>
            <li page0-data-num="4">6岁以上</li>
          </ul>
          <!-- 城市插件 -->
          <div class="content-block">
            <input id="demo1" type="text" readonly="" placeholder="城市选择特效"  value="请点击选择城市"/>
            <input id="value1" type="hidden" value="20,234,504"/>
          </div>
          <!-- 城市插件 -->
        </div>
        <h5 class="btnStartK" id="btnStart"></h5>
      </div>
      <!-- 宝宝信息 -->
      <!-- <p class="p1Img3"><img src="images/p1_img3.png" /></p> -->
    </article>
    <!-- /page0 -->
    <!-- page1 -->
    <article class="swiper-slide swiper-slide2" data-hash="page2">
      <div class="rocketK rocketK1">
        <p class="rocketFire rocketFire1"></p>
        <p class="rocket rocket1"></p>
      </div>
      <div class="question question1">
        <h2>题目一</h2>
        <p class="mamaQuestion">宝妈/或者宝爸能否唱10首以上的儿歌？</p>
        <p class="babyQuestion">宝宝是否上过英文早教或双语/国际幼儿园</p>
      </div>
      <p class="btnYes btnYes1" id="btnYes1" page1-data-num="1"></p>
      <p class="btnNo btnNo1" id="btnNo1" page1-data-num="0"></p>
    </article>
    <!-- /page1 -->
    <!-- page2 -->
    <article class="swiper-slide swiper-slide3" data-hash="page3">
      <div class="rocketK rocketK2">
        <p class="rocketFire rocketFire2"></p>
        <p class="rocket rocket2"></p>
      </div>
      <div class="question question2">
        <h2>题目二</h2>
        <p class="mamaQuestion">能否给孩子讲10本以上的英文绘本<br>并针对绘本图片内容进行扩展？</p>
        <p class="babyQuestion">宝宝能否唱出10首以上的儿歌</p>
      </div>
      <p class="btnYes btnYes2" id="btnYes2" page2-data-num="1"></p>
      <p class="btnNo btnNo2" id="btnNo2" page2-data-num="0"></p>
    </article>
    <!-- /page2 -->
    <!-- page3 -->
    <article class="swiper-slide swiper-slide4" data-hash="page4">
      <div class="rocketK rocketK3">
        <p class="rocketFire rocketFire3"></p>
        <p class="rocket rocket3"></p>
      </div>
      <div class="question question3">
        <h2>题目三</h2>
        <p class="mamaQuestion">起床、吃饭、睡觉、玩游戏这几个场景<br>是否都能用5句以上的英文和宝宝交流？</p>
        <p class="babyQuestion page3FontSize">宝宝是否看过5本上的绘本，并能够熟练的<br>用词汇或者小短语回答爸爸妈妈的英文提问</p>
      </div>
      <p class="btnYes btnYes3" id="btnYes3" page3-data-num="1"></p>
      <p class="btnNo btnNo3" id="btnNo3" page3-data-num="0"></p>
    </article>
    <!-- /page3 -->

    <!-- page4 -->
    <article class="swiper-slide swiper-slide5" data-hash="page5">
      <p class="code"></p>
      <p class="shadow"></p>
      <div class="parachute">
        <p class="parachuteHeader1"></p>
        <p class="parachuteHeader2"></p>
        <p class="parachuteHeader3"></p>
        <p class="parachuteBody"></p>
      </div>

      <p class="light5"></p>

      <div class="resultTextBg">
        <div class="resultText">
          <h3>您的宝宝适合</h3>
          <h5 id="resultTextH5"></h5>
        </div>
      </div>
    </article>
    <!-- /page4 -->
  </div>
</section>
<!-- 课表 -->
<div class="syllabus" id="syllabus">
  <div class="syllabus1">
    <p class="cherry1"></p>
    <p class="cherry2"></p>
    <h5 class="prev" id="cherry1BtnPrev"></h5>
    <h5 class="next" id="cherry2BtnNext"></h5>
  </div>
  <div class="syllabus2">
    <p class="strawberry1"></p>
    <p class="strawberry2"></p>
    <h5 class="prev" id="strawberry1BtnPrev"></h5>
    <h5 class="next" id="strawberry2BtnNext"></h5>
  </div>
  <div class="syllabus3">
    <p class="apple1"></p>
    <p class="apple2"></p>
    <h5 class="prev" id="apple1BtnPrev"></h5>
    <h5 class="next" id="apple2BtnNext"></h5>
  </div>
  <div class="btnClose" id="btnClose"></div>
</div>
<!-- /课表 -->
<script>
  var mySwiper = new Swiper('.swiper-container',{
    preloadImages:true,
  })
</script>