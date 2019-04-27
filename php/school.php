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
  <link rel="stylesheet" type="text/css" href="css/iconfont.css"/>
  <style type="text/css">
  	
  		body{
  			background-color: gainsboro;
  			 padding: 10px 15px;
  			
  		}
  		
  		.p1{
  			border: 1px solid gainsboro;
  			height: 80px;
  		}
  		button.weui-btn_default{
  			width: 90%;
  			margin: 20px 20px;
  			border-radius: 20px;
  			color: dodgerblue;
  			/*background-color: lightgrey;*/
  		}
  		.icon-luyinji{
  			font-size: 18px;
  		}
  		.img{
  			width: 120px;
  			height: 100px;
  			border: 1px solid gainsboro;
  			float:left;
  			text-align: center;
  			padding-top: 20px;
  			color:gainsboro ;
  		}
  		.img1{
  			margin: 0px 10px 20px 20px;
  		}
  		.icon-tupian1{
  			z-index: 999;
  			font-size: 30px;
  		}
  		.weui-btn_primary{
  			background-color: dodgerblue;
  			position: fixed;
  			bottom: 0px;
  		}
  </style>
</head>
<body>
	<div class="weui-cells">
		    <a class="weui-cell weui-cell_access" href="javascript:;">
		        <div class="weui-cell__bd">
		            <p>接收人</p>
		        </div>
		        <div class="weui-cell__ft">初三数学集体冲刺五班6名学生</div>
		    </a>
		</div>
		<div class="weui-cells">
		    <div class="weui-cell">
		        <div class="weui-cell__bd">
		            <p>标题</p>
		        </div>
		        <div class="weui-cell__ft">5.9日随堂测试</div>
		    </div>
		</div>
		
		<div class="weui-cells">
		    <div class="weui-cell">
		        <div class="weui-cell__bd weui-cell__bd1">
		            <p>内容</p>
		        </div>
		        
		    </div>
		    <div class="weui-cell">
		        <div class="weui-cell__bd">
		            <p class="p1">请同学们完成以下试卷，并于明天上午上课前提交给老师</p>
		        </div>
				</div>
		
		<img src="" alt="" id="image" style="width: 100%;" />
		 <button id="startRecord" class="weui-btn weui-btn_default iconfont icon-luyinji">点击录制语音</button>
		 
		 
		 <div id="choose" class="img img1 ">
		 		<span class=" iconfont icon-tupian1"></span>
		 	
		 		<p>添加图片</p>
		 </div>
		 <div id="choose1" class="img img2">
		 		<span class=" iconfont icon-tupian1"></span>
		 		<p>添加图片</p>
		 </div>
		 
		 
		</div>
		
	 <button id="" class="weui-btn weui-btn_primary">提交</button>
		
	
  
 
  
  
 
  <!--<button id="stopRecord" class="weui-btn weui-btn_primary">停止录音</button>
  <button id="playVoice" class="weui-btn weui-btn_primary">播放录音</button>
  <button id="stopVoice" class="weui-btn weui-btn_primary">停止播放</button>-->

  
  
  
   
  
</body>




<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
 
  //声明全局变量
  var localId = null;
  var serverId = null;
  
  
  
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: ["chooseImage","previewImage","startRecord","stopRecord","playVoice","stopVoice","translateVoice","onVoicePlayEnd","onVoiceRecordEnd"]
  });
  
  
  wx.ready(function () {
    console.log("ready OK")
  
    

    
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
	
document.querySelector("#choose1").onclick=function(){
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






</script>
</html>
