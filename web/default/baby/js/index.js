//全局变量
var page0Index1 = 0;
var page0Index2 = 0;
var page1Index1 = 0;
var page2Index1 = 0;
var page3Index1 = 0;
//page0


//宝宝信息下拉选项
$("#p0Select1ClickBtn").click(function(){
	if ($("#p0Select1").is(":visible")) {
		$("#p0Select1").hide();
	}else{
		$("#p0Select1").show();
	}
});
$("#p0Select1 li").click(function(){
	var p0SelectNum = $(this).attr("page0-data-num");
	//alert(p1SelectNum);
	$("#p0Select1").hide();
	$("#p0Select1ClickBtn").html($(this).text());
	$("#p0Select1ClickBtn").attr({"page0-data-num":p0SelectNum});
	page0Index1 = p0SelectNum;
	if(p0SelectNum==1){
		$(".mamaQuestion").show();
		$(".babyQuestion").hide();
	}else{
		$(".mamaQuestion").hide();
		$(".babyQuestion").show();
	}
});
//function requiredOption(){}

//animate
function page0AnimateAdd(){
	$(".p0Title").addClass("p0TitleAnimate");
	$(".p0Img2").addClass("p0Img2Animate");
	$(".p0Img").addClass("p0ImgAnimate");
	$(".babyMassage").addClass("babyMassageAnimate");
}
function page0AnimateRemove(){
	$(".p0Title").removeClass("p0TitleAnimate");
	$(".p0Img2").removeClass("p0Img2Animate");
	$(".p0Img").removeClass("p0ImgAnimate");
	$(".babyMassage").removeClass("babyMassageAnimate");
}
function page0JqueryAdd(){
	page0AnimateAdd();
	var t1 = setTimeout(function(){
		$(".swiper-slide1").hide();
		page0AnimateRemove();
		page1AnimateAdd();
	},2200);
}




$("#btnStart").click(function(){

	babyarea = $("#demo1").val();
	if(page0Index1==0){
		alert("请选择宝宝年龄^_^");
		return false;
	} else if (babyarea === '请点击选择城市'){
		alert("请选择宝宝地址^_^");
		return false;
	}
	else {
		$.ajax({
			url:"http://www.baby.com/baby/test",
			dataType:"json",
			async:true,
			data:{'age':page0Index1, 'area':babyarea, 'type':page0Index1},
			type:"post",
			success:function (data){
				$("#userid").attr('value', data.id);
				page0JqueryAdd();
			},
			error:function(){
				alert('异常');
			}

		});
	}

	//if(page0Index1==0){
	//	alert("请选择宝宝年龄^_^");
	//	return false;
	//}/*else if(page0Index2==0){
	//	alert("请点击选择城市^_^");
	//	return false;
	//}*/else{
	//	page0JqueryAdd();
	//}
});
//page1 animate
function page1AnimateAdd(){
	$(".rocketK1").addClass("rocketKInAnimate");
	var t2 = setTimeout(function(){
		$(".rocketK1").removeClass("rocketKInAnimate");
		$(".rocketK1").addClass("rocketKFloatAnimate");
		$(".rocketFire1").addClass("rocketFireAnimate");
	},1200);
	//clearTimeOut(t2);
}
function page1AnimteYesAdd(){
	$(".question1").addClass("questionAnimateL");
	$(".btnNo1").addClass("btnNoAnimate");
	$(".rocketK1").addClass("rocketKInOutimate");
}
function page1AnimteNoAdd(){
	$(".question1").addClass("questionAnimateR");
	$(".btnYes1").addClass("btnYesAnimate");
	$(".rocketK1").addClass("rocketKInOutimate");
}
function page1AnimateRemove(){
	$(".question1").removeClass("questionAnimateL");
	$(".question1").removeClass("questionAnimateR");
	$(".btnYes1").removeClass("btnYesAnimate");
	$(".btnNo1").removeClass("btnNoAnimate");
	$(".rocketK1").removeClass("rocketKInOutimate");
	$(".rocketK1").removeClass("rocketKInAnimate");
	$(".rocketK1").removeClass("rocketKFloatAnimate");
	$(".rocketFire1").removeClass("rocketFireAnimate");
}
//1111
$("#btnYes1").click(function(){
	page1Index1 = 1;
	page1AnimteYesAdd();
	addResult(1);
	var t2a = setTimeout(function(){
		$(".swiper-slide2").hide();
		page1AnimateRemove();
		//alert("0");
		page2AnimateAdd();
	},2200);

	clearTimeOut(t2a);
});
$("#btnNo1").click(function(){
	page1Index1 = 0;
	page1AnimteNoAdd();
	addResult(2);
	var t2b = setTimeout(function(){
		$(".swiper-slide2").hide();
		page1AnimateRemove();
		//alert("0");
		page2AnimateAdd();
	},2200);

	clearTimeOut(t2b);
});
//page2 animate
function page2AnimateAdd(){
	$(".rocketK2").addClass("rocketKInAnimate");
	var t3 = setTimeout(function(){
		$(".rocketK2").removeClass("rocketKInAnimate");
		$(".rocketK2").addClass("rocketKFloatAnimate");
		$(".rocketFire2").addClass("rocketFireAnimate");
	},1200);
	clearTimeOut(t3);
}
function page2AnimteYesAdd(){
	$(".question2").addClass("questionAnimateL");
	$(".btnNo2").addClass("btnNoAnimate");
	$(".rocketK2").addClass("rocketKInOutimate");
}
function page2AnimteNoAdd(){
	$(".question2").addClass("questionAnimateR");
	$(".btnYes2").addClass("btnYesAnimate");
	$(".rocketK2").addClass("rocketKInOutimate");
}
function page2AnimateRemove(){
	$(".question2").removeClass("questionAnimateL");
	$(".question2").removeClass("questionAnimateR");
	$(".btnYes2").removeClass("btnYesAnimate");
	$(".btnNo2").removeClass("btnNoAnimate");
	$(".rocketK2").removeClass("rocketKInOutimate");
	$(".rocketK2").removeClass("rocketKInAnimate");
	$(".rocketK2").removeClass("rocketKFloatAnimate");
	$(".rocketFire2").removeClass("rocketFireAnimate");
}
//22222
$("#btnYes2").click(function(){
	page2Index1 = 1;
	page2AnimteYesAdd();
	addResult(3);
	var t3a = setTimeout(function(){
		$(".swiper-slide3").hide();
		page2AnimateRemove();
		$(".rocketK3").addClass("rocketKInAnimate");
		var t4 = setTimeout(function(){
			$(".rocketK3").removeClass("rocketKInAnimate");
			$(".rocketK3").addClass("rocketKFloatAnimate");
			$(".rocketFire3").addClass("rocketFireAnimate");
		},1200);
		clearTimeOut(t4);
	},2200);

	clearTimeOut(t3a);
});
$("#btnNo2").click(function(){
	page2Index1 = 0;
	page2AnimteNoAdd();
	addResult(4);
	var t3b = setTimeout(function(){
		$(".swiper-slide3").hide();
		page2AnimateRemove();
		$(".rocketK3").addClass("rocketKInAnimate");
		var t4 = setTimeout(function(){
			$(".rocketK3").removeClass("rocketKInAnimate");
			$(".rocketK3").addClass("rocketKFloatAnimate");
			$(".rocketFire3").addClass("rocketFireAnimate");
		},1200);
		clearTimeOut(t4);
	},2200);

	clearTimeOut(t3b);
});
//page3 animate
function page3AnimateAdd(){
	$(".rocketK3").addClass("rocketKInAnimate");
	var t4 = setTimeout(function(){
		$(".rocketK3").removeClass("rocketKInAnimate");
		$(".rocketK3").addClass("rocketKFloatAnimate");
		$(".rocketFire3").addClass("rocketFireAnimate");
	},1200);
	clearTimeOut(t4);
}
function page3AnimteYesAdd(){
	$(".question3").addClass("questionAnimateL");
	$(".btnNo3").addClass("btnNoAnimate");
	$(".rocketK3").addClass("rocketKInOutimate");
}
function page3AnimteNoAdd(){
	$(".question3").addClass("questionAnimateR");
	$(".btnYes3").addClass("btnYesAnimate");
	$(".rocketK3").addClass("rocketKInOutimate");
}
function page3AnimateRemove(){
	$(".question3").removeClass("questionAnimateL");
	$(".question3").removeClass("questionAnimateR");
	$(".btnYes3").removeClass("btnYesAnimate");
	$(".btnNo3").removeClass("btnNoAnimate");
	$(".rocketK3").removeClass("rocketKInOutimate");
	$(".rocketK3").removeClass("rocketKInAnimate");
	$(".rocketK3").removeClass("rocketKFloatAnimate");
	$(".rocketFire3").removeClass("rocketFireAnimate");
}
//333333
$("#btnYes3").click(function(){
	page3Index1 = 1;
	resultTextH5();
	page3AnimteYesAdd();
	addResult(5);
	var t4a = setTimeout(function(){
		$(".swiper-slide4").hide();
		page3AnimateRemove();
		/*$(".rocketK4").addClass("rocketKInAnimate");
		var t5 = setTimeout(function(){
			$(".rocketK4").removeClass("rocketKInAnimate");
			$(".rocketK4").addClass("rocketKFloatAnimate");
			$(".rocketFire4").addClass("rocketFireAnimate");
		},1200);
		clearTimeOut(t5);*/
		page4AnimateAdd();
	},2200);

	clearTimeOut(t4a);
});
$("#btnNo3").click(function(){
	page3Index1 = 0;
	resultTextH5();
	page3AnimteNoAdd();
	addResult(6);
	var t4b = setTimeout(function(){
		$(".swiper-slide4").hide();
		page3AnimateRemove();
		/*$(".rocketK4").addClass("rocketKInAnimate");
		var t5 = setTimeout(function(){
			$(".rocketK4").removeClass("rocketKInAnimate");
			$(".rocketK4").addClass("rocketKFloatAnimate");
			$(".rocketFire4").addClass("rocketFireAnimate");
		},1200);
		clearTimeOut(t5);*/
		page4AnimateAdd();
	},2200);

	clearTimeOut(t4b);
});
//page4 animate
function parachuteFadeInOut(){
	var t7a = setTimeout(function(){
		$(".parachuteHeader1").fadeOut(500);
		$(".parachuteHeader2").fadeIn(500);
	},3000);
	var t7b = setTimeout(function(){
		$(".parachuteHeader2").fadeOut(500);
		$(".parachuteHeader3").fadeIn(500);
	},3800);
}
function page4AnimateAdd(){
	$(".parachute").addClass("parachuteAnimate");
	$(".shadow").addClass("shadowAnimate");
	parachuteFadeInOut();
	$(".light1").addClass("light1Animate");
	$(".light2").addClass("light2Animate");
	$(".light3").addClass("light3Animate");
	$(".light4").addClass("light4Animate");
	$(".light5").addClass("light5Animate");
	$(".resultTextBg").addClass("resultTextBgAnimate");
	$(".resultText").addClass("resultTextAnimate");
}
function page4AnimateRemove(){
	$(".parachute").removeClass("parachuteAnimate");
	$(".shadow").removeClass("shadowAnimate");
	parachuteFadeInOut();
	$(".light1").removeClass("light1Animate");
	$(".light2").removeClass("light2Animate");
	$(".light3").removeClass("light3Animate");
	$(".light4").removeClass("light4Animate");
	$(".light5").removeClass("light5Animate");
	$(".resultTextBg").removeClass("resultTextBgAnimate");
	$(".resultText").removeClass("resultTextAnimate");
}
//评估结果
function resultTextH5(){
	var resutlNum = page1Index1 + page2Index1 + page3Index1;
	if(page0Index1==1){
		$("#resultTextH5").html("樱桃基础班");
	}else if(page0Index1==2){
		$("#resultTextH5").html("草莓基础班");
	}else if(page0Index1==3 || page0Index1==4){
		if(resutlNum>=3){
			$("#resultTextH5").html("苹果基础班");
		}else{
			$("#resultTextH5").html("草莓基础班");
		}
	}
}

//添加题
function addResult(answerid) {
	var babyid = $("#userid").val();

	if (babyid > 0) {
		$.ajax({
			url:"/baby/add",
			dataType:"json",
			async:true,
			data:{'userid':babyid, 'answerid':answerid},
			type:"post",
			success:function (data){

			},
			error:function(){
				alert("异常！");
				return false;
			}

		});
	}

}
//课程表切换
$("#cherry1BtnPrev").click(function(){
	$("#cherry1BtnPrev").hide();
	$("#cherry2BtnNext").show();
	$(".cherry2").hide();
	$(".cherry1").show();
})
$("#cherry2BtnNext").click(function(){
	$("#cherry2BtnNext").hide();
	$("#cherry1BtnPrev").show();
	$(".cherry2").show();
	$(".cherry1").hide();
})
$("#strawberry1BtnPrev").click(function(){
	$("#strawberry1BtnPrev").hide();
	$("#strawberry2BtnNext").show();
	$(".strawberry2").hide();
	$(".strawberry1").show();
})
$("#strawberry2BtnNext").click(function(){
	$("#strawberry2BtnNext").hide();
	$("#strawberry1BtnPrev").show();
	$(".strawberry2").show();
	$(".strawberry1").hide();
})
$("#apple1BtnPrev").click(function(){
	$("#apple1BtnPrev").hide();
	$("#apple2BtnNext").show();
	$(".apple2").hide();
	$(".apple1").show();
})
$("#apple2BtnNext").click(function(){
	$("#apple2BtnNext").hide();
	$("#apple1BtnPrev").show();
	$(".apple2").show();
	$(".apple1").hide();
})
//评估结果
function resultTextH5(){
	var resutlNum = page1Index1 + page2Index1 + page3Index1;
	if(page0Index1==1){
		$("#resultTextH5").html("樱桃基础班");
			var t8a = setTimeout(function(){
				$("#syllabus").show();
				$(".syllabus1").show();
				$(".syllabus2").hide();
				$(".syllabus3").hide();
			},9000);
	}else if(page0Index1==2){
		$("#resultTextH5").html("草莓基础班");
		var t8b = setTimeout(function(){
				$("#syllabus").show();
				$(".syllabus2").show();
				$(".syllabus1").hide();
				$(".syllabus3").hide();
			},9000);
	}else if(page0Index1==3 || page0Index1==4){
		if(resutlNum>=3){
			$("#resultTextH5").html("苹果基础班");
			var t8c = setTimeout(function(){
				$("#syllabus").show();
				$(".syllabus3").show();
				$(".syllabus1").hide();
				$(".syllabus2").hide();
			},9000);
		}else{
			$("#resultTextH5").html("草莓基础班");
			var t8c = setTimeout(function(){
				$("#syllabus").show();
				$(".syllabus2").show();
				$(".syllabus1").hide();
				$(".syllabus3").hide();
			},9000);
		}
	}
}
$("#btnClose").click(function(){
	$("#syllabus").hide();
})