<?php
/* 主题检测更新部分 */
function theme_check_update($hook_suffix)
{
    add_action('admin_print_footer_scripts', 'theme_update_notice');
    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');
}
add_action('admin_enqueue_scripts', 'theme_check_update');

function theme_update_notice()
{
    $hjyl = wp_get_theme();
    ?>
        <script>
            jQuery(document).ready(function($) {
                var v = <?php echo $hjyl->get('Version'); ?>;
                $.ajax({
                    url: 'https://hilau.com/check_update.json?v=' + v,
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == true) {
                            show(data.version, data.download);
                        }
                    }
                });

                var show = function(new_v, d_url) {
                    var $menuAppearance = $("#menu-appearance");
                    $menuAppearance.pointer({
                        content: '<h3>更新提示</h3><p>HJYL_HILAU 主题现已更新至 V' + new_v + '，可能包含重要更新<br/>请前往 <a target="_blank" href="https://github.com/ylgod/HJYL_HILAU">Github</a> / <a href="' + d_url + '">直接下载</a></p>',
                        position: {
                            edge: "left",
                            align: "center"
                        },
                        close: function() {
                            $.post(ajaxurl, {
                                pointer: "git_options_pointer",
                                action: "dismiss-wp-pointer"
                            });
                        }
                    }).pointer("open").pointer("widget").find("a").eq(0).click(function() {
                        var href = $(this).attr("href");
                        $menuAppearance.pointer("close");
                        setTimeout(function() {
                            location.href = href;
                        }, 700);
                        return false;
                    });

                    $(window).on("resize scroll", function() {
                        $menuAppearance.pointer("reposition");
                    });
                    $("#collapse-menu").click(function() {
                        $menuAppearance.pointer("reposition");
                    });
                }
            });
        </script>

    <?php
}

    /* 主题检测更新部分 */
?>
