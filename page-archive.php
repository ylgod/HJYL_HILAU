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
					if(!empty($options['singlar_google_ad'])){
					echo '<figure class="singlar_google_ad mx-auto">';
						echo $options['singlar_google_ad'];
					echo '</figure>';
					}
				?>
				</div><!-- .entry-content -->
				<div id="archives">
				    <div id="archives-content">
					<div class="graph">
					    <ul class="months">
					    </ul>
					    <ul class="days">
					    </ul>
					    <ul class="squares">
					      <!-- added via javascript -->
					    </ul>
					</div>
					<script>
					drawHeatmap();
					function drawHeatmap() {
					    const dailyPostCounts = <?php echo $daily_post_counts_json; ?>;
					    // 访问数据
					    const labels = Object.keys(dailyPostCounts); // 获取日期数组
					    const data = Object.values(dailyPostCounts); // 获取文章数量数组

					    const heatmapContainer = document.querySelector('.squares');
					    heatmapContainer.innerHTML = ''; // 清空容器

					    // 输出日期和数量
					    labels.forEach((date, index) => {
					        //console.log(`日期: ${date}, 文章数量: ${data[index]}`);
					        const count = data[index];
					        const dayBlock = document.createElement('li');
					        //dayBlock.style.width = '10px'; // 每个块的宽度
					        //dayBlock.style.height = '10px'; // 每个块的高度
					        //dayBlock.style.margin = '2px'; // 块之间的间距
					        dayBlock.style.backgroundColor = getColorForCount(count);
					        dayBlock.title = `${date} : ${data[index]}`; // 鼠标悬停时显示的提示

					        heatmapContainer.appendChild(dayBlock);
					    });
					}

					function getColorForCount(count) {
					    if (count === 0) return '#EBEDF0'; // 白色表示没有文章
					    if (count <= 1) return '#C6E48B'; // 浅绿色表示低等数量文章
					    if (count <= 5) return '#7BC96F'; // 深绿色表示低等数量文章
					    return '#216e39'; // 更深的绿色表示大量文章
					}

					const today = new Date();
					const year = today.getFullYear();
					const date = new Date(year,0,1);
					const dayOfWeek = date.getDay();
					const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
					const weekDaysList = document.querySelector('.days');

					// 按顺序添加星期
					for (let i = 0; i < days.length; i++) {
					    const listItem = document.createElement('li');
					    listItem.textContent = days[i];
					    weekDaysList.appendChild(listItem);
					}

					const monthList = document.querySelector('.months');
					// 定义一个数组，包含每个月的英文简写
					const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
					const currentMonth = today.getMonth() + 1; // 获取当前月份（0-11）

					// 重新排序月份
					const sortedMonths = [
					    ...monthNames.slice(currentMonth), // 当前月份及之后的月份
					    ...monthNames.slice(0, currentMonth) // 之前的月份倒序
					];
					// 遍历月份数组并创建li标签
					sortedMonths.forEach(month => {
					    const li = document.createElement('li'); // 创建li元素
					    li.textContent = month; // 设置li的文本内容
					    monthList.appendChild(li); // 将li添加到ul中
					});
					</script>

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
				            $output .= '<div class="brick"><a href="'.esc_url( get_permalink() ) .'"><span class="time">'.get_the_time('n-d').'</span>'.get_the_title() .'<em>('. get_comments_number('0', '1', '%') .')</em></a></div>';
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
				                $html .= in_array($i, $value) ? ("<li class='month monthed' id='mont-$key-$i'>$i</li>") : null;
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