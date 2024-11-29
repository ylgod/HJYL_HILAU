<?php
error_reporting(E_ALL ^ E_NOTICE);//镇魔石，镇压一切魑魅魍魉！
if ( !class_exists('myCustomFields') ) {
 
    class myCustomFields {
        /**
        * @var  string  $prefix  自定义栏目前缀，一个完整的自定义栏目是需要前缀+name的，比如我的前缀是git_,name下面有baidu_submit，那么完整的自定义栏目就是git_baidu_submit.
        */
        var $prefix = 'hjyl_';
        /**
        * @var  array  $postTypes  这是自定义面板的使用范围，这里一般就是在文章以及页面
        */
        var $postTypes = array( "page", "post" );
        /**
        * @var  array  $customFields  开始组件自定义面板数组
		* @下面这些中文部分不支持本地化函数__()，后续再更新
        */
        var $customFields = array(
            array(
                "name"          => "download_name",
                "title"         => '下载名称',
                "description"   => "这里填写你要下载的资源名称",
                "type"          => "text",
                "scope"         => array("post", "page"),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "download_size",
                "title"         => "文件大小",
                "description"   => "填写文件的大小，比如：233M。",
                "type"          => "text",
                "scope"         => array("post", "page"),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "download_link",
                "title"         => "下载链接",
                "description"   => "填写下载链接，格式是：链接   名称   备注，每个内容之间用三个空格隔开。",
                "type"          => "textarea",
                "scope"         => array("post", "page"),
                "capability"    => "edit_posts"
            )
        );
        /**
        * PHP 5 Constructor
        */
        function __construct() {
            add_action( 'admin_menu', array( $this, 'createCustomFields' ) );
            add_action( 'save_post', array( $this, 'saveCustomFields' ), 1, 2 );
            // 下面这句可以关闭WordPress自带的自定义栏目，但是不推荐，需要的话可以开启
            //add_action( 'do_meta_boxes', array( $this, 'removeDefaultCustomFields' ), 10, 3 );
        }
        /**
        * 创建一组你自己的自定义栏目
        */
        function createCustomFields() {
            if ( function_exists( 'add_meta_box' ) ) {
                foreach ( $this->postTypes as $postType ) {
                    add_meta_box( 'my-custom-fields', __('Download Options', 'HJYL_HILAU'), array( $this, 'displayCustomFields' ), $postType, 'normal', 'high' );
                }
            }
        }
        /**
        * 在文章发布页显示出来面板
        */
        function displayCustomFields() {
            global $post;
            ?>
            <div class="form-wrap">
                <?php
                wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
                foreach ( $this->customFields as $customField ) {
                    // Check scope
                    $scope = $customField[ 'scope' ];
                    $output = false;
                    foreach ( $scope as $scopeItem ) {
                        switch ( $scopeItem ) {
                            default: {
                                if ( $post->post_type == $scopeItem )
                                    $output = true;
                                break;
                            }
                        }
                        if ( $output ) break;
                    }
                    // 检查权限
                    if ( !current_user_can( $customField['capability'], $post->ID ) )
                        $output = false;
                    // 通过则输出
                    if ( $output ) { ?>
                        <div class="form-field form-required">
                            <?php
                            switch ( $customField[ 'type' ] ) {
                                case "checkbox": {
                                    // Checkbox 组件
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>  ';
                                    echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="1"';
                                    if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "1" )
                                        echo ' checked="checked"';
                                    echo '" style="width: auto;" />';
                                    break;
                                }
                                case "textarea":{
                                    // Text area
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="5">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
                                    break;
                                }
                                default: {
                                    // Plain text field
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                    break;
                                }
                            }
                            ?>
                            <?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
                        </div>
                    <?php
                    }
                } ?>
            </div>
            <?php
        }
        /**
        * 保存自定义栏目数据
        */
        function saveCustomFields( $post_id, $post ) {
            if ( !isset( $_POST[ 'my-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
                return;
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
            if ( ! in_array( $post->post_type, $this->postTypes ) )
                return;
            foreach ( $this->customFields as $customField ) {
                if ( current_user_can( $customField['capability'], $post_id ) ) {
                    if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
                        $value = $_POST[ $this->prefix . $customField['name'] ];
                        update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
                    } else {
                        delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
                    }
                }
            }
        }
 
    } // End Class
 
} // End if class exists statement
 
// Instantiate the class
if ( class_exists('myCustomFields') ) {
    $myCustomFields_var = new myCustomFields();
}
?>