		<footer id="footer" class="site-footer">
		<div class="copyright">
			<p><?php _e('CopyRight', 'HJYL_HILAU'); ?>&nbsp;&copy;&nbsp;<?php echo date("Y"); ?>&nbsp;<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>. <?php printf(__('%1$s Powered by %2$s', 'HJYL_HILAU'), '<a href="'.esc_url( __( 'https://hjyl.org/', 'HJYL_HILAU' ) ).'" title="Designed by hjyl.org">HJYL_HILAU</a>', '<a href="'.esc_url( __( 'https://wordpress.org/', 'HJYL_HILAU' ) ).'">WordPress</a>'); ?>. </p>
			
			<p><?php $options = get_theme_mod('hjyl_hilau_options'); if(!empty($options['footer_code'])){ echo $options['footer_code']; }?></p>
			
		</div>
		
		<div id="hjylUp">
			<i><?php echo hjyl_get_svg( array( 'icon' => 'arrow-up' ) ); ?></i>
		</div>	
		</footer><!-- #footer -->
	</div>
<?php wp_footer(); ?>
</body>
</html>