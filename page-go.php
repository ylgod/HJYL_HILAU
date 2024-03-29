<?php
/*
Template Name: go跳转页面
*/
//自定义跳转地址
$cars = array(
   array("qcloud",'https://hjyl.org/'),
   array("upyun",'https://hjyl.org/'),
   array("trustutn",'https://hjyl.org/'),
   array("gfvps",'https://hjyl.org/'),
   array("360scan",'https://hjyl.org/')
   );

if(strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") ||
    strpos($_SERVER['REQUEST_URI'], "base64")) {
        @header("HTTP/1.1 414 Request-URI Too Long");
        @header("Status: 414 Request-URI Too Long");
        @header("Connection: Close");
        @exit;
}
//通过QUERY_STRING取得完整的传入数据，然后取得url=之后的所有值，兼容性更好
$t_url = preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]);

//此处可以自定义一些特别的外链，不需要可以删除以下5行
foreach($cars as $k=>$val){
    if($t_url==$val[0] ) {
      $t_url =  $val[1];
      $t_vip = 1;
    }
}
 
//数据处理
if(!empty($t_url)) {
    //判断取值是否加密
    if ($t_url == base64_encode(base64_decode($t_url))) {
        $t_url =  base64_decode($t_url);
    }
    //对取值进行网址校验和判断
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i',$t_url,$matches);
    if($matches){
        $url = $t_url;
        $title = '页面加载中,请稍候...';
    } else {
        preg_match('/\./i',$t_url,$matche);
        if($matche){
            $url = 'http://'.$t_url;
            $title = '页面加载中,请稍候...';
        } else {
            $url = 'http://'.$_SERVER['HTTP_HOST'];
            $title = '参数错误，正在返回首页...';
        }
    }
    } else {
        $title = '参数缺失，正在返回首页...';
        $url = 'http://'.$_SERVER['HTTP_HOST'];
    }
?>
<html>
<!--
@name:aeink goto
@description:AE博客跳转页面
@author:墨渊
@time:2017-09-22
@copyright:AE博客&墨渊
@author url:http://www.aeink.com/791.html
@ps:你想删我也拦不住看你自觉性吧！！
-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="noindex, nofollow" />
    <noscript><meta http-equiv="refresh" content="1;url='<?php echo $url;?>';"></noscript>
    <meta charset="UTF-8">
<!--[if IE 8]>
    <style>
        .ie8 .alert-circle,.ie8 .alert-footer{display:none}.ie8 .alert-box{padding-top:75px}.ie8 .alert-sec-text{top:45px}
    </style>
<![endif]-->

    <title><?php echo $title;?></title>
    <style>
        body{margin:0;padding:0;background:#E6EAEB;font-family:Arial,'微软雅黑','宋体',sans-serif}.main{position:absolute;left:calc(50% - 200px);top:calc(50% - 13em)}.alert-box{display:none;position:relative;margin:auto;padding:180px 85px 22px;border-radius:10px 10px 0 0;background:#FFF;box-shadow:5px 9px 17px rgba(102,102,102,.75);width:286px;color:#FFF;text-align:center}.alert-box p{margin:0}.alert-circle{position:absolute;top:-50px;left:111px}.alert-sec-circle{stroke-dashoffset:0;stroke-dasharray:735;transition:stroke-dashoffset 1s linear}.alert-sec-text{position:absolute;top:11px;left:190px;width:76px;color:#000;font-size:68px}.alert-sec-unit{font-size:34px}.alert-body{margin:35px 0}.alert-head{color:#242424;font-size:28px}.alert-concent{margin:25px 0 14px;color:#7B7B7B;font-size:18px}.alert-concent p{line-height:27px}.alert-btn{display:block;border-radius:10px;background-color:rgba(178,34,34,1);height:55px;line-height:55px;width:286px;color:#FFF;font-size:20px;text-decoration:none;letter-spacing:2px}.alert-btn:hover{background-color:rgba(128,0,0,1)}.alert-footer{margin:0 auto;height:42px;width:120px}.alert-footer-icon{float:left}.alert-footer-text{float:left;border-left:2px solid #EEE;padding:3px 0 0 5px;height:40px;color:rgba(178,34,34,1);font-size:12px;text-align:left}.alert-footer-text p{color:#7A7A7A;font-size:22px;line-height:18px}
    </style>
<?php if(has_site_icon()) { wp_site_icon(); }?>
</head>
<body class="ie8" style="">
<div class="main">
    <div id="js-alert-box" class="alert-box" style="display:block">
        <svg class="alert-circle" width="234" height="234"><circle cx="117" cy="117" r="108" fill="#FFF" stroke="rgba(178,34,34,1)" stroke-width="17"></circle><circle id="js-sec-circle" class="alert-sec-circle" cx="117" cy="117" r="108" fill="transparent" stroke="#F4F1F1" stroke-width="18" transform="rotate(-90 117 117)" style="stroke-dashoffset:-514px"></circle><text class="alert-sec-unit" x="100" y="172" fill="#BDBDBD">秒</text></svg>
        <div id="js-sec-text" class="alert-sec-text">
        3
        </div>
        <div class="alert-body">
            <div id="js-alert-head" class="alert-head">
            <?php echo $title;?>
            </div>
            <div class="alert-concent">
            <p>一万年太久，只争朝夕</p>
            </div>
            <a id="js-alert-btn" class="alert-btn" href="<?php echo $url;?>">立即前往</a>
        </div>
        <div class="alert-footer clearfix">
            <svg width="46px" height="42px" class="alert-footer-icon"><circle fill-rule="evenodd" clip-rule="evenodd" fill="#7B7B7B" stroke="#DEDFE0" stroke-width="2" stroke-miterlimit="10" cx="21.917" cy="21.25" r="17"></circle><path fill="#FFF" d="M22.907,27.83h-1.98l0.3-2.92c-0.37-0.22-0.61-0.63-0.61-1.1c0-0.71,0.58-1.29,1.3-1.29s1.3,0.58,1.3,1.29 c0,0.47-0.24,0.88-0.61,1.1L22.907,27.83z M18.327,17.51c0-1.98,1.61-3.59,3.59-3.59s3.59,1.61,3.59,3.59v2.59h-7.18V17.51z M27.687,20.1v-2.59c0-3.18-2.59-5.76-5.77-5.76s-5.76,2.58-5.76,5.76v2.59h-1.24v10.65h14V20.1H27.687z"></path><circle fill-rule="evenodd" clip-rule="evenodd" fill="#FEFEFE" cx="35.417" cy="10.75" r="6.5"></circle><polygon fill="#7B7B7B" stroke="#7B7B7B" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="35.417,12.16 32.797,9.03 31.917,10.07 35.417,14.25 42.917,5.29 42.037,4.25 "></polygon></svg>
            <div class="alert-footer-text">
                <p>secure</p>安全加密
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function alertSet(e) {
    document.getElementById("js-alert-box").style.display = "block", document.getElementById("js-alert-head").innerHTML = e;
    var t = 5,
        n = document.getElementById("js-sec-circle");
    document.getElementById("js-sec-text").innerHTML = t, setInterval(function() {
        //禁止其他网站调用此跳转
        //var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");
        //if (!MyHOST.test(document.referrer)) {
        // location.href="http://" + MyHOST;
        //}
        if (0 == t) location.href = "<?php echo $url;?>";
        else {
            t -= 1, document.getElementById("js-sec-text").innerHTML = t;
            var e = Math.round(t / 5 * 735);
            n.style.strokeDashoffset = e - 735
        }
    }, 970)
}
</script>
<script>alertSet("<?php echo $title;?>");</script>
</body>
</html>