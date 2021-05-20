<?php
//投稿
if( isset($_POST['tougao_form']) && $_POST['tougao_form'] == 'send'){
	if ( isset($_COOKIE["tougao"]) && ( time() - $_COOKIE["tougao"] ) < 120 ){
		wp_die('您投稿也太勤快了吧，先歇会儿,2分钟后再来投稿吧！');
	}
	// 表单变量初始化
	$name = trim($_POST['tougao_authorname']);
	$email = trim($_POST['tougao_authoremail']);
	$site = trim($_POST['tougao_site']);
	$title = strip_tags(trim($_POST['tougao_title']));
	$category = isset( $_POST['cat'] ) ? (int)$_POST['cat'] : 0;
	$content = $_POST['tougao_content'];
	$tags = strip_tags(trim($_POST['tougao_tags']));
	if(!empty($site)){
		$author='<a href="'.$site.'" title="'.$name.'" target="_blank" rel="nofollow">'.$name.'</a>';
	}else{
		$author=$name;
	}
	$info='感谢: '.$author.' '.'投稿'.' 。';
	global $wpdb;
	$db="SELECT post_title FROM $wpdb->posts WHERE post_title = '$title' LIMIT 1";
	if ($wpdb->get_var($db)){
		wp_die('发现重复文章.你已经发表过了.或者存在该文章');
	}
	// 表单项数据验证
	if ($name == ''){
		wp_die('昵称必须填写，且长度不得超过20个字');
	}elseif(mb_strlen($name,'UTF-8') > 20 ){
		wp_die('你的名字怎么这么长啊，起个简单易记的吧，长度不要超过20个字哟!');
	}elseif($title == ''){
		wp_die('文章标题必须填写，长度6到50个字之间');
	}elseif(mb_strlen($title,'UTF-8') > 50 ){
		wp_die('文章标题太长了，长度不得超过50个字');
	}elseif(mb_strlen($title,'UTF-8') < 6 ){
		wp_die('文章标题太短了，长度不得少于过6个字');
	}elseif ($email ==''|| !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)){
		wp_die('Email必须填写，必须符合Email格式');
	}elseif ($content == ''){
		wp_die('内容必须填写，不要太长也不要太短,300到10000个字之间');
	}elseif (mb_strlen($content,'UTF-8') >10000){
		wp_die('你也太能写了吧，写这么多，别人看着也累呀，300到10000个字之间');
	}elseif (mb_strlen($content,'UTF-8') < 300){
		wp_die('太简单了吧，才写这么点，再加点内容吧，300到10000个字之间');
	}elseif ($tags == ''){
		wp_die('不要这么懒吗，加个标签好人别人搜到你的文章，长度在2到20个字！');
	}elseif (mb_strlen($tags,'UTF-8') < 2){
		wp_die('不要这么懒吗，加个标签好人别人搜到你的文章，长度在2到20个字！');
	}elseif (mb_strlen($tags,'UTF-8') > 40){
		wp_die('标签不用太长，长度在2到40个字就可以了！');
	}elseif ($site == ''){
		wp_die('请留下贵站名称，要不怎么宣传呀，这点很重要哦！');
	}elseif ($site == ''){
		wp_die('请填写原文链接，好让其他人浏览你的网站，这是最重要的宣传方式哦！');
	}else{
		$post_content = $info.'<br />'.$content;
		$tougao = array(
			'post_title' => $title,
			'post_content' => $post_content,
			'tags_input'  =>$tags,
			'post_status' => 'pending', //publish
			'post_category' => array($category)
		);
	// 将文章插入数据库
	$status = wp_insert_post( $tougao );
	if ($status != 0){
		setcookie("tougao", time(), time()+1);
		echo ('<div style="text-align:center;">'.'<title>'.bloginfo('name').'</title>'.'</div>');
		echo ('<div style="text-align:center;">'.'<meta charset="UTF-8" /><meta http-equiv="refresh" content="5;URL=http://www.hilau.com">'.'</div>');
		echo ('<div style="position:relative;font-size:14px;margin-top:100px;text-align:center;">'.'投稿成功，感谢投稿，5秒钟后将返回网站首页！'.'</div>');
		echo ('<div style="position:relative;font-size:20px;margin-top:30px;text-align:center;">'.'<a href="/" >'.'立即返回网站首页'.'</a>'.'</div>');
		wp_mail( array('i@hjyl.org', $email), "您的投稿主人已经收到啦！", $info, array('Content-Type: text/html; charset=UTF-8') );
		die();
	}else{
		wp_die('投稿失败！');
	}
	}
}
?>