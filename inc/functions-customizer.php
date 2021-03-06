<?php 
//自定义地址
function hjyl_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'hjyl_hilau_setting', array(
		'priority'       => 700,
		'capability'     => 'edit_theme_options',
		'title'      => __('HJYL_HILAU settings', 'HJYL_HILAU'),
	));
		
	//basic options 
	$wp_customize->add_section(
        'basic_options',
        array(
            'title' => __('Basic Options','HJYL_HILAU'),
           'priority' => 10,
			'panel' => 'hjyl_hilau_setting',
        ));
		
	//slide options
	$wp_customize->add_section(
        'slide_options',
        array(
            'title' => __('Slide Options','HJYL_HILAU'),
           'priority' => 25,
			'panel' => 'hjyl_hilau_setting',
        ));	

	//social link 
	$wp_customize->add_section(
        'copyright_social_icon',
        array(
            'title' => __('Social Links','HJYL_HILAU'),
           'priority' => 35,
			'panel' => 'hjyl_hilau_setting',
        ));	

	//AD options 
	$wp_customize->add_section(
        'google_ad_options',
        array(
            'title' => __('AD Options','HJYL_HILAU'),
           'priority' => 45,
			'panel' => 'hjyl_hilau_setting',
        ));
		
	//SEO options 
	$wp_customize->add_section(
        'seo_options',
        array(
            'title' => __('SEO Options','HJYL_HILAU'),
           'priority' => 15,
			'panel' => 'hjyl_hilau_setting',
        ));	
		
	//选中为博客模式，不选中为cms模式
	$wp_customize->add_setting(
    'hjyl_hilau_options[is_blog]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[is_blog]',
		array(
			'label' => __('Blog if selected(Hide Slide part)','HJYL_HILAU'),
			'section' => 'basic_options',
			'type' => 'checkbox',
		)
	);
	
	//打赏--->支付宝二维码(建议尺寸150*150)
	$wp_customize->add_setting(
    'hjyl_hilau_options[alipay]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
	new WP_Customize_Upload_Control( $wp_customize, 'hjyl_hilau_options[alipay]',
	array(
		'label' => __( 'Alipay QRcode', 'HJYL_HILAU' ),
		'description' => esc_html__( 'upload your alipay QRcode. 150px*150px', 'HJYL_HILAU'),
		'section' => 'basic_options',
		'settings'   =>  'hjyl_hilau_options[alipay]',
	) ) );
	
	//打赏--->微信二维码(建议尺寸150*150)
	$wp_customize->add_setting(
    'hjyl_hilau_options[wxpay]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
	new WP_Customize_Upload_Control( $wp_customize, 'hjyl_hilau_options[wxpay]',
	array(
		'label' => __( 'WeChat Pay QRcode', 'HJYL_HILAU' ),
		'description' => esc_html__( 'upload your WeChat Pay QRcode. 150px*150px', 'HJYL_HILAU'),
		'section' => 'basic_options',
		'settings'   =>  'hjyl_hilau_options[wxpay]',
	) ) );
	
	// 幻灯片分类设置
 	$wp_customize->add_setting(
    'hjyl_hilau_options[slide]',
    array(
		'capability' => 'edit_theme_options',
		'default' => 1,
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		)
	);	
	$wp_customize->add_control( new Category_Dropdown_Custom_Control( $wp_customize, 'hjyl_hilau_options[slide]', array(
		'label'   => __('Select category for slide','HJYL_HILAU'),
		'section' => 'slide_options',
		'settings'   => 'hjyl_hilau_options[slide]',
	) ) );
	
	
	// QQ link
	$wp_customize->add_setting(
    'hjyl_hilau_options[social_qq]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[social_qq]',
		array(
			'label' => __('QQ No.','HJYL_HILAU'),
			'section' => 'copyright_social_icon',
			'type' => 'text',
		)
	);

	//Weibo link
	
	$wp_customize->add_setting(
    'hjyl_hilau_options[social_weibo]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod'
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[social_weibo]',
		array(
			'label' => __('Weibo Account','HJYL_HILAU'),
			'section' => 'copyright_social_icon',
			'type' => 'text',
		)
	);
	
	//WeChat link 上传微信二维码
	$wp_customize->add_setting(
    'hjyl_hilau_options[social_wechat]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
	new WP_Customize_Upload_Control( $wp_customize, 'hjyl_hilau_options[social_wechat]',
	array(
		'label' => __( 'WeChat QRcode', 'HJYL_HILAU' ),
		'section' => 'copyright_social_icon',
		'settings'   =>  'hjyl_hilau_options[social_wechat]',
	) ) );

	//mail link
	
	$wp_customize->add_setting(
    'hjyl_hilau_options[social_mail]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[social_mail]',
		array(
			'label' => __('Email','HJYL_HILAU'),
			'section' => 'copyright_social_icon',
			'type' => 'text',
		)
	);

	//顶部广告所有页面显示/首页显示设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[is_home_ad]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[is_home_ad]',
		array(
			'label' => __('Only Show AD on Home Page','HJYL_HILAU'),
			'section' => 'google_ad_options',
			'type' => 'checkbox',
		)
	);
	
	//首页广告设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[home_google_ad]',
		array(
			'default' => '',
			'validate_callback' => 'wp_filter_kses',
			'transport' => 'refresh',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[home_google_ad]',
		array(
			'label' => __('Home Ad','HJYL_HILAU'),
			'description' => esc_html__( 'AD for 468px*60px', 'HJYL_HILAU'),
			'section' => 'google_ad_options',
			'type' => 'code_editor',
		)
	);	
	
	//文章页内容右边广告设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[single_google_ad]',
		array(
			'default' => '',
			'validate_callback' => 'wp_filter_kses',
			'transport' => 'refresh',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[single_google_ad]',
		array(
			'label' => __('Single Right Ad','HJYL_HILAU'),
			'description' => esc_html__( 'AD for 336px*280px', 'HJYL_HILAU' ),
			'section' => 'google_ad_options',
			'type' => 'code_editor',
		)
	);	
	
	//文章页面内容底部广告设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[singlar_google_ad]',
		array(
			'default' => '',
			'validate_callback' => 'wp_filter_kses',
			'transport' => 'refresh',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[singlar_google_ad]',
		array(
			'label' => __('Singlar Bottom Ad','HJYL_HILAU'),
			'description' => esc_html__( 'AD for 468px*60px', 'HJYL_HILAU' ),
			'section' => 'google_ad_options',
			'type' => 'code_editor',
		)
	);
	
	//archive页面广告设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[archive_google_ad]',
		array(
			'default' => '',
			'validate_callback' => 'wp_filter_kses',
			'transport' => 'refresh',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[archive_google_ad]',
		array(
			'label' => __('Archive Ad','HJYL_HILAU'),
			'description' => esc_html__( 'AD for 468px*60px', 'HJYL_HILAU' ),
			'section' => 'google_ad_options',
			'type' => 'code_editor',
		)
	);	

	//关键词设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[keywords]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[keywords]',
		array(
			'label' => __('keywords','HJYL_HILAU'),
			'description' => esc_html__( 'keywords, separate by ","', 'HJYL_HILAU' ),
			'section' => 'seo_options',
			'type' => 'text',
		)
	);
	
	//描述设置
	$wp_customize->add_setting(
    'hjyl_hilau_options[description]',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[description]',
		array(
			'label' => __('description','HJYL_HILAU'),
			'description' => esc_html__( 'description', 'HJYL_HILAU' ),
			'section' => 'seo_options',
			'type' => 'textarea',
		)
	);	
	
	//网站底部代码
	$wp_customize->add_setting(
    'hjyl_hilau_options[footer_code]',
		array(
			'default' => '',
			'sanitize_callback' => 'footer_sanitize_html',
			'transport' => 'postMessage',
			'type' => 'theme_mod',
		)
	);
	$wp_customize->add_control(
    'hjyl_hilau_options[footer_code]',
		array(
			'label' => __('Footer Code','HJYL_HILAU'),
			'description' => esc_html__( 'Footer Code', 'HJYL_HILAU' ),
			'section' => 'seo_options',
			'type' => 'code_editor',
		)
	);

function footer_sanitize_html( $input ) {
    return force_balance_tags( $input );
	}	
}

add_action( 'customize_register', 'hjyl_customize_register' );


?>