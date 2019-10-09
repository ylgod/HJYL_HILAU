<?php

function HJYL_HILAU_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'HJYL_HILAU_upgrade_notice' );
}
add_action( 'after_switch_theme', 'HJYL_HILAU_switch_theme' );


function HJYL_HILAU_upgrade_notice() {
	$message = sprintf( __( 'HJYL_HILAU THEME requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'HJYL_HILAU' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}


function HJYL_HILAU_customize() {
	wp_die(
		sprintf(
			__( 'HJYL_HILAU THEME requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'HJYL_HILAU' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'HJYL_HILAU_customize' );


function HJYL_HILAU_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'HJYL_HILAU THEME requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'HJYL_HILAU' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'HJYL_HILAU_preview' );
