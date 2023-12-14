<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for='s'><?php _e( 'Search', 'HJYL_HILAU' ); ?></label>
	<input type="search" id="s" class="search-field" value="<?php echo trim( get_search_query() ); ?>" name="s" placeholder="<?php _e( 'Search...', 'HJYL_HILAU'); ?>" required="required" />
	<button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'HJYL_HILAU' ); ?>" />
		<?php _e( 'Enter', 'HJYL_HILAU'); ?>
    </button>
</form>
