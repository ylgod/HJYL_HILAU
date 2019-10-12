<?php 
/*
Template Name: 归档页面
*/
get_header();
$options = get_theme_mod( 'hjyl_hilau_options');
?>
	<section id="primary" class="content-area row">
		<main id="main" class="site-main col-xs-12 col-md-12 col-lg-12">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
				<?php
					if(!empty($options['single_google_ad'])){
					echo '<figure class="single_google_ad">';
						echo $options['single_google_ad'];
					echo '</figure>';
					}
				?>
				</div><!-- .entry-content -->
				<div id="archives">     
					<div id="archives-content">     
					<?php      
						$the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' );     
						$year=0; $mon=0; $i=0; $j=0;     
						$all = array();     
						$output = '';     
						while ( $the_query->have_posts() ) : $the_query->the_post();     
							$year_tmp = get_the_time('Y');     
							$mon_tmp = get_the_time('n');     
							$y=$year; $m=$mon;     
							if ($mon != $mon_tmp && $mon > 0) $output .= '</div></div>';     
							if ($year != $year_tmp) { // output year    
								$year = $year_tmp;     
								$all[$year] = array();     
							}     
							if ($mon != $mon_tmp) { // output month     
								$mon = $mon_tmp;     
								array_push($all[$year], $mon);     
								$output .= "<div class='archive-title' id='arti-$year-$mon'><h3>$year-$mon</h3><div class='archives archives-$mon' data-date='$year-$mon'>";     
							}     
							$output .= '<div class="brick"><a href="'.get_permalink() .'"><span class="time">'.get_the_time('n-d').'</span>'.get_the_title() .'<em>('. get_comments_number('0', '1', '%') .')</em></a></div>';     
						endwhile;     
						wp_reset_postdata();     
						$output .= '</div></div>';     
						echo $output;     
							
						$html = "";     
						$year_now = date("Y");     
						foreach($all as $key => $value){// output left year    
							$html .= "<li class='year' id='year-$key'><a href='#' class='year-toogle' id='yeto-$key'>$key</a><ul class='monthall'>";     
							for($i=12; $i>0; $i--){     
								if($key == $year_now && $i > $value[0]) continue;     
								$html .= in_array($i, $value) ? ("<li class='month monthed' id='mont-$key-$i'>$i</li>") : ("<li class='month'>$i</li>");     
							}     
							$html .= "</ul></li>";  
						}     
					?>    
					</div>     
					<div id="archive-nav">     
						<ul class="archive-nav"><?php echo $html;?></ul>     
					</div>     
				</div><!-- #archives -->
				</article>

				<div class="clearfix"></div>
		</main>
	</section>
	
<?php get_footer(); ?>