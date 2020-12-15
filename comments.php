<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'HJYL_HILAU' ); ?></p>
<?php return;endif; ?>
<?php if ( have_comments() ) : ?>
		<h3 id="comments-title"><span><?php echo hjyl_get_svg( array( 'icon' => 'comment' ) ); ?><?php comments_popup_link( __( ' Leave a reply', 'HJYL_HILAU' ), __( ' 1 Comment ', 'HJYL_HILAU' ), __( ' % Comments', 'HJYL_HILAU' ),'comments-views',__( ' Comments Off', 'HJYL_HILAU' ) ); ?></span></h3>
	<ol class="commentlist" id="comments">
		<?php wp_list_comments( array( 'callback' => 'hjyl_comment','type' => 'comment' ) );?>
			<p id="comments-nav">
				<?php paginate_comments_links('prev_text='.__('Previous', 'HJYL_HILAU').'&next_text='.__('Next', 'HJYL_HILAU').'');?>
			</p>
			
<?php endif; ?>
				<script type="text/javascript" charset="utf-8">
				var changeMsg = "<?php echo  esc_js( __('(Toggle)', 'HJYL_HILAU') ); ?>";
				var closeMsg = "<?php echo esc_js( __('(Close)', 'HJYL_HILAU') ); ?>";

				function isnull(val){
					if (val != null) {
					var str = val.replace(/(^\s*)|(\s*$)/g, '');//去除空格;
					}
					if(str == '' || str == undefined || str == null){
						jQuery('#comment-author-info').show();
						jQuery('.comment-welcomeback').hide();
					}else{
						jQuery('.comment-welcomeback').show();
						jQuery('#comment-author-info').hide();
					}	
				}
				function olo_toggleCommentAuthorInfo() {
					jQuery('#comment-author-info').slideToggle('slow', function(){
						if ( jQuery('#comment-author-info').css('display') == 'none' ) {
							jQuery('#toggle-comment-author-info').text(changeMsg);
						} else {
							jQuery('#toggle-comment-author-info').text(closeMsg);
						}
					});
				}
				jQuery(document).ready(function(jQuery) {
					isnull(jQuery('#author').val());
				});
				</script>
<?php 
		
		$aria_req = ( $req ? " aria-required='true'" : '' );
       	$fields =  array(
            'author' => '<div class="comment-welcomeback">'.sprintf(__('Welcome <strong>%s</strong>', 'HJYL_HILAU'), $comment_author).'<a href="javascript:olo_toggleCommentAuthorInfo();" id="toggle-comment-author-info">'.__('(Toggle)', 'HJYL_HILAU').'</a></div><div id="comment-author-info" class="row"><p class="comment-form-author col-sm-4"><input class="form-control" id="author" name="author" type="text" value="'.esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /><label for="author">' . __( 'Name', 'HJYL_HILAU' ) . '</label> ' . ( $req ? '<span class="required">' . __( '(required)', 'HJYL_HILAU' ) . '</span>' : '' ).'</p>',
            'email'  => '<p class="comment-form-email col-sm-4"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /><label for="email">' . __( 'Email', 'HJYL_HILAU' ) . '</label>'. ( $req ? '<span class="required">' . __( '(required)', 'HJYL_HILAU' ) . '</span>' : '' ).'</p>',
            'url'    => '<p class="comment-form-url col-sm-4">'.'<input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />'.'<label for="url">' . __( 'Website', 'HJYL_HILAU') . '</label></p></div>',
	);
        $comment_form_args = array(
          	'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
            'comment_field'        => '<p class="comment-form-comment"><textarea class="form-control" aria-required="true" rows="8" cols="70" name="comment" id="comment" onkeydown="if(event.ctrlKey){if(event.keyCode==13){document.getElementById(\'submit\').click();return false}};"></textarea></p>',
            'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'HJYL_HILAU' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'HJYL_HILAU' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'comment_notes_before' => null,
            'comment_notes_after'  => null,
            'id_form'              => 'commentform',
            'class_form'              => 'comment-form',
            'id_submit'            => 'submit',
            'class_submit'            => 'btn btn-danger',
            'title_reply'          => __( 'Leave a Reply', 'HJYL_HILAU' ),
            'title_reply_to'       => __( 'Leave a Reply to %s', 'HJYL_HILAU'),
            'cancel_reply_link'    => __( 'Cancel reply', 'HJYL_HILAU'),
            'label_submit'         => __( 'Post Comment', 'HJYL_HILAU'),
    );
    comment_form($comment_form_args);
 ?>
	</ol>
<div class="clearfix"></div>
<?php $havepings="pings"; foreach($comments as $comment){if(get_comment_type() != 'comment' && $comment->comment_approved != '0'){ $havepings = 1; break; }}if($havepings == 1) : ?>
<div id="pings">
	<h3 id="pings-title"><span><?php echo hjyl_get_svg( array( 'icon' => 'chain' ) ); ?> <a><?php _e('Pingbacks', 'HJYL_HILAU'); ?></a></span></h3>
		<ul id="pinglist"><?php wp_list_comments('type=pings&per_page=0&callback=hjyl_pings'); ?></ul>
</div>

<?php endif; ?>