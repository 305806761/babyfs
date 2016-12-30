/***
* 微信分享给朋友/朋友圈
* @wxShare  {object} 分享给朋友/朋友圈的参数和成功失败回调
* wxShare.title.desc.url.imgUrl.successCallback.cancelCallback.ok()
* @return {[type]} [description]
*/
//location.href.split('#')[0]
$.get('http://course.babyfs.cn/we-chat/share/', { url: location.href.split('#')[0] }).done(function(res) {
    var datares = $.parseJSON(res);
    wx.config(datares);

}).fail(function() { console.log('微信分享获取后台参数ajax失败！'); });

var wxShare = {
    ok: function() {
        var self = this;
        self.title = self.title ? self.title : '宝宝玩英语';
        self.desc = self.desc ? self.desc : '宝宝玩英语互动小游戏';
        self.link = self.link ? self.link : location.href;
        self.imgUrl = self.imgUrl ? self.imgUrl : 'http://www.babyfs.cn/skin/web/index_img/logo.png';
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