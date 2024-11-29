<?php
// 获取当前日期
$current_date = new DateTime();

// 获取当月的最后一天
$last_day_of_month = new DateTime($current_date->format('Y-m-t'));

// 获取365天前的日期
$last_year_date = new DateTime($current_date->format('Y-m-t'));

$last_year_date->modify('-365 days');

// 获取365天前的周日
$last_year_sunday = clone $last_year_date;
$last_year_sunday->modify('last sunday');

// 确保最后的周日是365天前的日期
if ($last_year_sunday > $last_year_date) {
    $last_year_sunday->modify('-7 days');
}
    // 将日期字符串转换为时间戳
    $start_timestamp = $last_year_sunday->format('Y-m-d');
    $end_timestamp = $last_day_of_month->format('Y-m-d');

// 类似GitHub活跃图 获取当前月到一年前的周日这段数据
function get_daily_post_counts($start_date, $end_date) {

    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);

    // 初始化一个数组来存储每日文章数量
    $daily_counts = [];

    // 循环遍历每一天
    for ($current = $start_timestamp; $current <= $end_timestamp; $current += DAY_IN_SECONDS) {
        // 获取当前日期
        $current_date = date('Y-m-d', $current);

        // 创建 WP_Query 参数
        $args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'date_query' => [
                [
                    'year'  => date('Y', $current),
                    'month' => date('m', $current),
                    'day'   => date('d', $current),
                ],
            ],
            'posts_per_page' => -1, // 获取所有匹配的文章
        ];

        // 执行查询
        $query = new WP_Query($args);

        // 统计当前日期的文章数量
        $daily_counts[$current_date] = $query->found_posts;

        // 清理查询
        wp_reset_postdata();
    }

    return $daily_counts;
}

// 调用函数并输出结果
$daily_post_counts = get_daily_post_counts($start_timestamp, $end_timestamp);

// 将结果转换为 JSON 格式
$daily_post_counts_json = json_encode($daily_post_counts);
