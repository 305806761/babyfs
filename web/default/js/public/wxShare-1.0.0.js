/***
* 微信分享给朋友/朋友圈
* @wxShare  {object} 分享给朋友/朋友圈的参数和成功失败回调
* wxShare.title.desc.url.imgUrl.successCallback.cancelCallback.ok()
* @return {[type]} [description]
*/
//location.href.split('#')[0]
$.get('http://course.babyfs.cn/we-chat/share/', { url: location.href.split('#')[0] }).done(function(res) {
    wx.config({
        debug: true,
        appId: res.appId,
        timestamp: res.timestamp,
        nonceStr: res.nonceStr,
        signature: res.signature,
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            // 'hideMenuItems',
            // 'showMenuItems',
            // 'hideAllNonBaseMenuItem',
            // 'showAllNonBaseMenuItem',
            // 'translateVoice',
            // 'startRecord',
            // 'stopRecord',
            // 'onRecordEnd',
            // 'playVoice',
            // 'pauseVoice',
            // 'stopVoice',
            // 'uploadVoice',
            // 'downloadVoice',
            // 'chooseImage',
            // 'previewImage',
            // 'uploadImage',
            // 'downloadImage',
            // 'getNetworkType',
            // 'openLocation',
            // 'getLocation',
            // 'hideOptionMenu',
            // 'showOptionMenu',
            // 'closeWindow',
            // 'scanQRCode',
            // 'chooseWXPay',
            // 'openProductSpecificView',
            // 'addCard',
            // 'chooseCard',
            // 'openCard'
        ]
    });

}).fail(function() { console.log('微信分享获取后台参数ajax失败！'); });
wx.ready(function(){
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    alert('aaa');
});
wx.error(function(res){
    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
    document.write(res);
});
var wxShare = {
    ok: function() {
        var self = this;
        self.title = self.title || 'title';
        self.desc = self.desc || 'desc';
        self.link = self.link || location.href;
        self.imgUrl = self.imgUrl || location.protocol + '//' + location.host + '/logo.jpg';
        wx.ready(function() {
            wx.onMenuShareAppMessage({
                title: self.title,
                desc: self.desc,
                link: self.link,
                imgUrl: self.imgUrl,
                success: function() {
                    console.log('分享给朋友成功！');
                    if (typeof self.successCallback === 'function') {
                        self.successCallback();
                    }
                },
                cancel: function() {
                    console.log('分享给朋友失败！');
                    if (typeof self.cancelCallback === 'function') {
                        self.cancelCallback();
                    }
                }
            });
            wx.onMenuShareTimeline({
                title: self.title2 || self.title,
                desc: self.desc2 || self.desc,
                link: self.link2 || self.link,
                imgUrl: self.imgUrl2 || self.imgUrl,
                success: function() {
                    console.log('分享到朋友圈成功！');
                    if (typeof self.successCallback2 === 'function') {
                        self.successCallback2();
                    } else if (typeof self.successCallback === 'function') {
                        self.successCallback();
                    }
                },
                cancel: function() {
                    console.log('分享到朋友圈失败！');
                    if (typeof self.cancelCallback2 === 'function') {
                        self.cancelCallback2();
                    } else if (typeof self.cancelCallback === 'function') {
                        self.cancelCallback();
                    }
                }
            });
        });
    }
}