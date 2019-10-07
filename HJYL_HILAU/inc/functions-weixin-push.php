<?php
/*
* 引用方糖气球评论微信推送
*/
function wpso_wechet_comment_notify($comment_id) {
$options = get_theme_mod('hjyl_hilau_options');
$wxPush = $options['wxpush'];
$text = __('You have new Message, Please Check it', 'HJYL_HILAU');
$comment = get_comment($comment_id);
        $desp = '
		'.__('Comment Author: ', 'HJYL_HILAU') . get_comment_author($comment_id) . '<br>
		'.__('Post Title: ', 'HJYL_HILAU') . get_the_title($comment->comment_post_ID) . '<br>
		'.__('Post Link: ', 'HJYL_HILAU') . get_the_permalink($comment->comment_post_ID) . '<br>
		'.__('Post Content: ', 'HJYL_HILAU') . $comment->comment_content . '
		'; //微信推送内容正文
$key = $wxPush;
$postdata = http_build_query(
array(
'text' => $text,
'desp' => $desp
)
);
$opts = array('http' =>
array(
'method' => 'POST',
'header' => 'Content-type: application/x-www-form-urlencoded',
'content' => $postdata
)
);
$context = stream_context_create($opts);
$admin_email = get_bloginfo ('admin_email');
$comment_author_email = trim($comment->comment_author_email);
if($admin_email!=$comment_author_email){
return $result = file_get_contents('http://sc.ftqq.com/'.$key.'.send', false, $context);
}
}
add_action('comment_post', 'wpso_wechet_comment_notify', 19, 2);
?>