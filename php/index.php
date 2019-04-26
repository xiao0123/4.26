<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxa27b39164863ef03", "4019b0ec83f1dc3ea1e8128991ba6390");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/weui.css"/>
  <style type="text/css">
  	
  		body{
  			
  			 padding: 10px 15px;
  			
  		}
  		
  		body button{
  			margin-bottom: 20px;
  		}
  	
  	
  </style>
</head>
<body>
  <img src="" alt="" id="image" style="width: 100%;" />
  <button id="choose" class="weui-btn weui-btn_plain-primary">照片</button>
  <button id="preview" class="weui-btn weui-btn_plain-primary">图片预览</button>
  <!--<button id="upload" class="weui-btn weui-btn_plain-primary">图片上传</button>
  <button id="download" class="weui-btn weui-btn_plain-primary">图片下载</button>-->
  
  <button id="startRecord" class="weui-btn weui-btn_primary">开始录音</button>
  <button id="stopRecord" class="weui-btn weui-btn_primary">停止录音</button>
  <button id="playVoice" class="weui-btn weui-btn_primary">播放录音</button>
  <button id="stopVoice" class="weui-btn weui-btn_primary">停止播放</button>
   <button id="translateVoice" class="weui-btn weui-btn_primary">录音转文字</button>
  
   
  <button id="getLocation" class="weui-btn weui-btn_plain-primary">定位</button>
  <button id="openLocation" class="weui-btn weui-btn_plain-primary">打开地图</button>
  
   <button id="scanQRCode" class="weui-btn weui-btn_primary">扫一扫</button>
</body>




<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  //声明全局变量
  var localId = null;
  var serverId = null;
  
  var latitude = 0; // 纬度，浮点数，范围为90 ~ -90
	var longitude = 0; // 经度，浮点数，范围为180 ~ -180。
	var speed = 0; // 速度，以米/每秒计
	var accuracy = 0; // 位置精度
  
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: ["onMenuShareAppMessage","onMenuShareTimeline","chooseImage","previewImage","startRecord","stopRecord","playVoice","stopVoice","translateVoice","onVoicePlayEnd","onVoiceRecordEnd","openLocation","getLocation","scanQRCode"]
  });
  
  
  wx.ready(function () {
    console.log("ready OK")
  
    
  //发送链接给朋友  
    wx.onMenuShareAppMessage({
			title: '五一放假通知...', // 分享标题
			desc: '五一放假时间做出重要调整，原本4天的时间延长至7天', // 分享描述
			link: 'http://demo.niyinlong.com/demo1/index.html', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: 'http://demo.niyinlong.com/demo1/image/tongzhi.jpg', // 分享图标
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () {
				 console.log("分享成功！")
			// 用户点击了分享后执行的回调函数
			}
			});
		//分享朋友圈
     wx.onMenuShareTimeline({ 
        title: '五一放假通知..', // 分享标题
        link: 'http://demo.niyinlong.com/demo1/index.html', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: 'http://demo.niyinlong.com/demo1/image/tongzhi.jpg', // 分享图标
        success: function () {
          // 设置成功
           console.log("分享成功！")
        }
    })
    
    //监听录音自动停止接口
    wx.onVoiceRecordEnd({
		// 录音时间超过一分钟没有停止的时候会执行 complete 回调
		complete: function (res) {
		localId = res.localId;
		}
		});
    
    //监听语音播放完毕接口
    wx.onVoicePlayEnd({
			success: function (res) {
			localId = res.localId; // 返回音频的本地ID
			}
			});
    
    
    
  });
  
  
  wx.error(function(res){
    console.log(res)
	});
	
	
	//照片
	document.querySelector("#choose").onclick=function(){
			wx.chooseImage({
			count: 1, // 默认9
			sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res) {
			localIds = res.localIds[0]; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
			document.querySelector("#image").setAttribute("src",localIds);
			}
			});
		
		
	}
	
	//照片预览
	document.querySelector("#preview").onclick=function(){
			wx.previewImage({
			current: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1556270634552&di=2bd95b47abd2744204100b7096adc975&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201802%2F23%2F20180223001335_jzzoo.jpg', // 当前显示图片的http链接
			urls: ["https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1556270634552&di=ed45e0ca35e9160d87fd09b360d644f8&imgtype=0&src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201712%2F25%2F20171225231405_aye4H.thumb.700_0.jpeg","https://timgsa.baidu.com/timg?image&quality=80&size=b10000_10000&sec=1556260664&di=cee2d6ccc62ee1b1012ecb4de073df73&src=http://b-ssl.duitang.com/uploads/item/201802/08/20180208001213_rgaer.thumb.700_0.jpg"] // 需要预览的图片http链接列表
			});
	}
	
	
document.querySelector("#startRecord").onclick=function(){
	wx.startRecord();
	
}
			
	document.querySelector("#stopRecord").onclick=function(){
			wx.stopRecord({
				success: function (res) {
				localId = res.localId;
				}
				});
	
}
	document.querySelector("#playVoice").onclick=function(){
			wx.playVoice({
				localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
				});
	
}
	document.querySelector("#stopVoice").onclick=function(){
			wx.stopVoice({
				localId: localId // 需要停止的音频的本地ID，由stopRecord接口获得
				});
	
}
	document.querySelector("#translateVoice").onclick=function(){
			wx.translateVoice({
				localId: localId, // 需要识别的音频的本地Id，由录音相关接口获得
				isShowProgressTips: 1, // 默认为1，显示进度提示
				success: function (res) {
				alert(res.translateResult); // 语音识别的结果
				}
				});
	
}



//获取地理位置接口
document.querySelector("#getLocation").onclick=function(){
		wx.getLocation({
			type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
			success: function (res) {
			latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
			longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
			speed = res.speed; // 速度，以米/每秒计
			accuracy = res.accuracy; // 位置精度
			}
			});
}

//使用微信内置地图查看位置接口
document.querySelector("#openLocation").onclick=function(){
	wx.openLocation({
		latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
		longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
		name: '非凡学院', // 位置名
		address: '徐家汇', // 地址详情说明
		scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
		infoUrl: 'http://www.feifanedu.com.cn' // 在查看位置界面底部显示的超链接,可点击跳转
		});
}
document.querySelector("#scanQRCode").onclick=function(){
	wx.scanQRCode({
		needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
		scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
		success: function (res) {
		var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
		console.log(result);
		}
		});
}


</script>
</html>
