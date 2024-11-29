<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	//return 'options-framework-theme';
    $option_name = get_option( 'stylesheet' );
    $option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
    return $option_name;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'HJYL_HILAU'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'HJYL_HILAU' ),
		'two' => __( 'Two', 'HJYL_HILAU' ),
		'three' => __( 'Three', 'HJYL_HILAU' ),
		'four' => __( 'Four', 'HJYL_HILAU' ),
		'five' => __( 'Five', 'HJYL_HILAU' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'HJYL_HILAU' ),
		'two' => __( 'Pancake', 'HJYL_HILAU' ),
		'three' => __( 'Omelette', 'HJYL_HILAU' ),
		'four' => __( 'Crepe', 'HJYL_HILAU' ),
		'five' => __( 'Waffle', 'HJYL_HILAU' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __( 'Basic Settings', 'HJYL_HILAU' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Blog Mode', 'HJYL_HILAU' ),
		'desc' => __( 'Blog if selected(Hide Slide part).', 'HJYL_HILAU' ),
		'id' => 'is_blog',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __( 'Alipay QRcode', 'HJYL_HILAU' ),
		'desc' => __( 'upload your alipay QRcode. 150px*150px.', 'HJYL_HILAU' ),
		'id' => 'alipay',
		'type' => 'upload'
	);

	$options[] = array(
		'name' => __( 'WeChat Pay QRcode', 'HJYL_HILAU' ),
		'desc' => __( 'upload your WeChat Pay QRcode. 150px*150px.', 'HJYL_HILAU' ),
		'id' => 'wxpay',
		'type' => 'upload'
	);

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Slide Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for slide', 'HJYL_HILAU' ),
			'id' => 'slide',
			'type' => 'select',
			'options' => $options_categories
		);
	}

	$options[] = array(
		'name' => __( 'QQ No.', 'HJYL_HILAU' ),
		'desc' => __( 'Fill your QQ No.', 'HJYL_HILAU' ),
		'id' => 'social_qq',
		'placeholder' => '4953363',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Email Account', 'HJYL_HILAU' ),
		'desc' => __( 'Fill your Email Account.', 'HJYL_HILAU' ),
		'id' => 'social_mail',
		'placeholder' => 'i@hjy.org',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Weibo Account', 'HJYL_HILAU' ),
		'desc' => __( 'Fill your Weibo Account.', 'HJYL_HILAU' ),
		'id' => 'social_weibo',
		'placeholder' => 'ylgod',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'WeChat QRcode', 'HJYL_HILAU' ),
		'desc' => __( 'upload your WeChat QRcode.', 'HJYL_HILAU' ),
		'id' => 'social_wechat',
		'type' => 'upload'
	);

	$options[] = array(
		'name' => __( 'SEO Settings', 'HJYL_HILAU' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'keywords', 'HJYL_HILAU' ),
		'desc' => __( 'fill your keywords, separate by ",".', 'HJYL_HILAU' ),
		'id' => 'keywords',
		'placeholder' => '皇家元林, hjyl, 博客',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'description', 'HJYL_HILAU' ),
		'desc' => __( 'description.', 'HJYL_HILAU' ),
		'id' => 'description',
		'placeholder' => '皇家元林的网站hilau.com是一个不错的技术分享网站.',
		'type' => 'textarea'
	);

	/**
	 * For $settings options see:
	 * https://developer.wordpress.org/reference/functions/wp_editor/
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	$wp_editor_settings = array(
		'textarea_rows' => 5,
		'media_buttons' => false,
		'tinymce' => array( 'quicktags' => false )
	);

	$options[] = array(
		'name' => __( 'Head Code', 'HJYL_HILAU' ),
		'desc' => __( 'Head Code. For example: css,js.', 'HJYL_HILAU' ),
		'id' => 'head_code',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	$options[] = array(
		'name' => __( 'Footer Code', 'HJYL_HILAU' ),
		'desc' => __( 'Footer Code. For example: Stat code, ICP No.', 'HJYL_HILAU' ),
		'id' => 'footer_code',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	//CMS首页栏目设置
	$options[] = array(
		'name' => __( 'CMS Home Settings', 'HJYL_HILAU' ),
		'type' => 'heading'
	);

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'First Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for First Options', 'HJYL_HILAU' ),
			'id' => 'first_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Second Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Second Options', 'HJYL_HILAU' ),
			'id' => 'second_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Third Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Third Options', 'HJYL_HILAU' ),
			'id' => 'third_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Fourth Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Fourth Options', 'HJYL_HILAU' ),
			'id' => 'fourth_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Fifth Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Fifth Options', 'HJYL_HILAU' ),
			'id' => 'fifth_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Sixth Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Sixth Options', 'HJYL_HILAU' ),
			'id' => 'sixth_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	if ( $options_categories ) {
		$options[] = array(
			'name' => __( 'Seventh Options', 'HJYL_HILAU' ),
			'desc' => __( 'Select category for Seventh Options', 'HJYL_HILAU' ),
			'id' => 'seventh_op',
			'type' => 'select',
			'options' => $options_categories
		);
	};

	$options[] = array(
		'name' => __( 'AD Settings', 'HJYL_HILAU' ),
		'type' => 'heading'
	);

	//首页广告设置
	$options[] = array(
		'name' => __( 'Only Show AD on Home Page', 'HJYL_HILAU' ),
		'desc' => __( 'Click here and Only Show AD on Home Page.', 'HJYL_HILAU' ),
		'id' => 'is_home_ad',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __( 'Home Ad', 'HJYL_HILAU' ),
		'desc' => __( 'Home AD for 468px*60px.', 'HJYL_HILAU' ),
		'id' => 'home_google_ad',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	//文章页内容右边广告设置
	$options[] = array(
		'name' => __( 'Single Right Ad', 'HJYL_HILAU' ),
		'desc' => __( 'Single Right AD for 336px*280px.', 'HJYL_HILAU' ),
		'id' => 'single_google_ad',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	//文章页面内容底部广告设置
	$options[] = array(
		'name' => __( 'Singlar Bottom Ad', 'HJYL_HILAU' ),
		'desc' => __( 'Singlar Bottom AD for 468px*60px.', 'HJYL_HILAU' ),
		'id' => 'singlar_google_ad',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	//archive页面广告设置
	$options[] = array(
		'name' => __( 'Archive Ad', 'HJYL_HILAU' ),
		'desc' => __( 'Archive Ad for 468px*60px.', 'HJYL_HILAU' ),
		'id' => 'archive_google_ad',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);


	return $options;
}