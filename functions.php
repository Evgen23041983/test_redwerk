<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//  


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentytwelve_setup() in a child theme, add your own twentytwelve_setup to your child theme's
 * functions.php file.
 *
 */

function mtst_setup() {

    add_theme_support( 'custom-logo' );
    add_theme_support( 'post-formats', array( 'ads' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'menus' );

    $defaults = array(
        'height'      => 45,
        'width'       => 37,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );

    add_theme_support( 'custom-logo', $defaults );
    load_theme_textdomain( 'mtst-text-domain', get_template_directory() . '/languages' );

    register_nav_menus( array(
        'mtstmenu' => __( 'mtstmenu', 'mtst-text-domain' ),
    ) );
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
    $title_form = 'Add Form';
    if (  ! post_exists( $title_form ) ) {
        $post_id = wp_insert_post(  wp_slash( array(
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_title'    => 'Add Form',
            'page_template' => 'page-form.php'
        ) ) );
    }

    $title_home = 'Home';
    if (  ! post_exists( $title_home ) ) {
        $post_id = wp_insert_post(  wp_slash( array(
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_title'    => 'Home'
        ) ) );
        update_option( 'page_on_front', $post_id );
        update_option( 'show_on_front', 'page' );
    }

    $title_ads = 'Border';
    if (  ! post_exists( $title_ads ) ) {
        $post_id = wp_insert_post(  wp_slash( array(
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_title'    => 'Border'

        ) ) );

    }
    
}

function  mtst_enqueue_style( $hook ) {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );

    wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css' );

    wp_enqueue_style( 'foodrecipe-style', get_stylesheet_directory_uri() . '/css/style.css' );

    wp_enqueue_script( 'bootstrap-script', get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '4.0', true );

    wp_enqueue_script( 'foodrecipe-script', get_stylesheet_directory_uri() . '/js/script.js',  array(), '4.0', true );
    wp_enqueue_script( 'form-script', get_stylesheet_directory_uri() . '/js/form-script.js',  array() );
    wp_localize_script( 'form-script', 'form_script_vars', array(
        'loading_img_message'    => __( 'Loading...', 'mtst-text-domain' ) . '<img class="mtst_loader" src="' . get_stylesheet_directory_uri() . '/images/loading.gif' . '" alt="" />'
         ) );
}

function mtst_add_admin_iris_scripts( $hook ){
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_media();
    wp_enqueue_script( 'mtst_script', get_stylesheet_directory_uri() . '/js/add-one-media.js' );
    wp_localize_script( 'mtst_script', 'mtst_vars', array(
        'mtst_nonce' 			=> wp_create_nonce( get_stylesheet_directory_uri(), 'mtst_ajax_nonce_field' ),
        'update_img_message'	=> __( 'Updating images...', 'mtst-text-domain' ) . '<img class="mtst_loader" src="' . get_stylesheet_directory_uri() . '/images/loading.gif' . '" alt="" />',
        'not_found_img_info'	=> __( 'No image found.', 'mtst-text-domain' ),
        'img_success'			=> __( 'All images are updated.', 'mtst-text-domain' ),
        'img_error'				=> __( 'Error:', 'mtst-text-domain' ) ) );
}



function  mtst_register_cars_post_type() {
    $args = array(
        'label'				=> __( 'Ad', 'quotes-and-tips' ),
        'singular_label'	=> __( 'Ads', 'quotes-and-tips' ),
        'public'			=> true,
        'show_ui'			=> true,
        'capability_type'	=> 'post',
        'hierarchical'		=> false,
        'rewrite'			=> true,
        'supports'			=> array( 'title' ),
        'menu_icon'			=> 'dashicons-products',
        'has_archive'       => true,
        'show_in_nav_menus' => true,
        'labels'			=> array(
            'name'          => __( 'Ads', 'mtst-text-domain' ),
            'all_items'     => __( 'Ads', 'mtst-text-domain' ),
            'singular_name' => __( 'Ad', 'mtst-text-domain' ),
            'add_new_item'  => __( 'Add New Ad', 'mtst-text-domain' ),
            'edit_item'     => __( 'Edit Ad', 'mtst-text-domain' ),
            'new_item'      => __( 'New Ad', 'mtst-text-domain' ),
            'view_item'     => __( 'View Ad', 'mtst-text-domain' ),
            'search_items'  => __( 'Search Ads', 'mtst-text-domain' ),
            'not_found'     => __( 'No ads found', 'mtst-text-domain' ),
            'menu_name'     => __( 'Ads', 'mtst-text-domain' )
        )
    );
    register_post_type( 'ads' , $args );

}

function mtst_custom_metabox() {
    global $post;
    $price_ad = get_post_meta( $post->ID, 'price_ad' );
    $textarea_ad = get_post_meta( $post->ID, 'textarea_ad' );
    ?>


    <table class="form-table">

        <tr>
            <th scope="row"><?php _e( 'Price', 'mtst-text-domain' ); ?></th>
            <td>
                <input id="price_ad" type="text" name="price_ad" value="<?php if ( ! empty( $price_ad) ) echo $price_ad[0]; ?>">
                <div class="bws_info"><?php _e( 'Enter the price of the car', 'mtst-text-domain' ); ?></div>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'About', 'mtst-text-domain' ); ?></th>
            <td>
                <textarea rows="10" cols="45" name="textarea_ad" id="textarea_ad" ><?php if ( ! empty( $textarea_ad) ) echo $textarea_ad[0]; ?></textarea>
            </td>
        </tr>

    </table>
<?php }


if ( ! function_exists( 'mtst_add_custom_metabox' ) ) {
    function mtst_add_custom_metabox() {
        add_meta_box( 'custom-metabox', __( 'Ad characteristics', 'mtst-text-domain' ), 'mtst_custom_metabox', 'ads', 'normal', 'high' );
        add_meta_box( 'mtst_metabox_images', __( 'Images', 'mtst-text-domain-pro' ), 'mtst_metabox_images_block', 'ads', 'normal', 'high' );
    }
}


function mtst_save_custom_field ( $post_id ) {

    if ( ( ( isset( $_POST['price_ad'] ) ) ) )  {
        update_post_meta( $post_id, 'price_ad', stripslashes( esc_html( $_POST['price_ad'] ) ) );
    }
    if ( ( ( isset( $_POST['textarea_ad'] ) ) ) )  {
        update_post_meta( $post_id, 'textarea_ad', stripslashes( esc_html( $_POST['textarea_ad'] ) ) );
    }
    if ( isset( $_POST['mtst_images'] ) ) {
        $attachment_ids = ! empty( $_POST['mtst_images'] ) ? array_filter( explode( ',', sanitize_text_field( $_POST['mtst_images'] ) ) ) : array();
        update_post_meta( $post_id, '_mtst_images', implode( ',', $attachment_ids ) );
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    return $post_id;
}


function mtst_custom_post_listing_shortcode() {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'ads',
        'color' => 'blue',
        'posts_per_page' => 50,
        'order' => 'DESC',
        'orderby' => 'title',
    ) );
    if ( $query->have_posts() ) { ?>
        <div class="clothes-listing">  
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class='bord'>
                    
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <?php $myvariable = ob_get_clean();
        return $myvariable;
    }
}

function my_template( $template ) {

    if( is_page( 'form' ) ){
        if ( $new_template = locate_template( array( 'form.php' ) ) )
            return $new_template ;
    }
    if( is_page( 'home' ) ){
        if ( $new_template = locate_template( array( 'page-home.php' ) ) )
            return $new_template ;
    }
    if( is_page( 'border' ) ){
        if ( $new_template = locate_template( array( 'page-border.php' ) ) )
            return $new_template ;
    }
    if ( get_post_type() == 'ads' ) {

        if ( is_single() ) {           
        
            if ( $theme_file = locate_template( array ( 'single-ads.php' ) ) ) {
               
                $template = $theme_file;
            } else {
                $template = get_stylesheet_directory_uri() . '/single-ads.php';
            }
        }
    }
    return $template;
}

function ajax_form(){
    global $post, $mail_to, $title;

    $time_ad = get_option( 'number_of_ads_a' );
    if ( empty( $time_ad ) ) {
            $time_ad = 60;
        }

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $title = sanitize_text_field( $_POST['title'] );
    $price = sanitize_text_field( $_POST['price'] );
    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_email( $_POST['email'] );
    $content = $_POST['textarea'];
   

    $post_id = wp_insert_post(  wp_slash( array(
        'post_status'   => 'publish',
        'post_type'     => 'ads',
        'post_title'    => $title,
        'meta_input'     => [ 'price_ad'=>  $price, 'textarea_ad'=>  $content ]
    ) ) );

    $file_array = [
        'name'     => $_FILES['file']['name'], 
        'tmp_name' => $_FILES['file']['tmp_name'],
        'error'    => 0,
        'size'     =>  $_FILES['file']['size'],
    ];
     wp_editor( $content, $post_id );

    $id = media_handle_sideload( $file_array, 0, 'inage' );
    $attachment_id = media_handle_upload( $_FILES, $post_id );
    
    update_post_meta( $post_id, 'price_ad',  $price );
    update_post_meta( $post_id, 'textarea_ad',  $content );
    update_post_meta( $post_id, '_mtst_images', $id );
    if( is_wp_error( $id ) ) {
        @unlink($file_array['tmp_name']);
        var_dump($id->get_error_messages());
    }
    $response = '';
    $mail_to = $email;
    $admin_mail = get_option( 'admin_email' );


    if( wp_mail( $admin_mail, 'New message', $title ) ) {
       $response = 'message submit';
    }

    add_action( 'admin_head', 'my_activation' );
    function my_activation() {
        if( ! wp_next_scheduled( 'my_new_event' ) ) {
            wp_schedule_single_event( time() + $time_ad, 'my_new_event' );
        }
    }

    add_action( 'my_new_event','do_this_in_an_hour' );
    function do_this_in_an_hour() {
        global $mail_to, $title;
        if( wp_mail( $mail_to, 'New ad', $title . 'сообщение опубликовано' ) ) {
           $response = 'Сообщение отправлено';
        }else
           $response = 'Ошибка при отправке';
        }
    
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
        echo $response;
        wp_die();
    }
}


if ( ! function_exists( 'mtst_metabox_images_block' ) ) {
    function mtst_metabox_images_block() {
        global $post; ?>
        <div id="mtst_images_container">
            <noscript><div class="error"><p><?php _e( 'Please enable JavaScript to add or delete images.', 'mtst-text-domain-pro' ); ?></p></div></noscript>
            <ul>
                <?php if ( metadata_exists( 'post', $post->ID, '_mtst_images' ) ) {
                    $mtst_images = get_post_meta( $post->ID, '_mtst_images', true );
                } 

                $attachments = array_filter( explode( ',', $mtst_images ) );

                $update_meta = false;

                if ( ! empty( $attachments ) ) {
                    foreach ( $attachments as $attachment_id ) {
                        $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

                        /* skip if attachment is empty */
                        if ( empty( $attachment ) ) {
                            $update_meta = true;
                            continue;
                        }

                        echo '<li class="mtst_single_image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                            ' . $attachment . '
                            <span class="mtst_delete_image"><a href="#" title="' . __( 'Delete image', 'mtst-text-domain-pro' ) . '">' . __( 'Delete', 'mtst-text-domain-pro' ) . '</a></span>
                        </li>';

                        $updated_images_ids[] = $attachment_id;
                    }

                    /* update product meta to set new mtst-text-domain ids */
                    if ( $update_meta && ! empty($updated_images_ids))
                    {
                        update_post_meta( $post->ID, '_mtst_images', implode( ',', $updated_images_ids ) );
                    }
                } ?>


            </ul>
            <input type="hidden" id="mtst_images" name="mtst_images" value="<?php echo esc_attr( $mtst_images ); ?>" />
        </div>
        <p class="mtst_add_mtst-text-domain_images hide-if-no-js">
            <a href="#" data-choose="<?php esc_attr_e( 'Add Images to mtst-text-domain', 'mtst-text-domain-pro' ); ?>" data-update="<?php esc_attr_e( 'Add to mtst-text-domain', 'mtst-text-domain-pro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'mtst-text-domain-pro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'mtst-text-domain-pro' ); ?>"><?php _e( 'Add images', 'mtst-text-domain-pro' ); ?></a>
        </p>
    <?php }
}

/**
 * Ajax function for updating images
 * @return void
 */
if ( ! function_exists( 'mtst_update_image' ) ) {
    function mtst_update_image() {
        global $wpdb, $mtst_options;
       // check_ajax_referer( plugin_basename( __FILE__ ), 'mtst_ajax_nonce_field' );
        $action = isset( $_REQUEST['action1'] ) ? $_REQUEST['action1'] : "";
        $id     = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : "";
        switch ( $action ) {
            case 'get_all_attachment':
                $array_parent_id = $wpdb->get_col( $wpdb->prepare( "
                    SELECT 
                        ID 
                    FROM 
                        {$wpdb->posts}
                    WHERE 
                        post_type = %s
                ", 'ads' ) );

                if ( ! empty( $array_parent_id ) ) {
                    $string_parent_id = implode( ",", $array_parent_id );

                    $metas = $wpdb->get_results( "
                        SELECT 
                            meta_value 
                        FROM 
                            {$wpdb->postmeta} 
                        WHERE 
                            meta_key = '_mtst_images' AND 
                            post_id IN (" . $string_parent_id . ")
                    ", ARRAY_A );

                    $result_attachment_id = '';
                    foreach ( $metas as $key => $value ) {
                        if ( ! empty( $value['meta_value'] ) ) {
                            $result_attachment_id .= $value['meta_value'] . ',';
                        }
                    }
                    $result_attachment_id_array = explode( ",", rtrim( $result_attachment_id, ',' ) );

                    $attached_id = $wpdb->get_results( "
                        SELECT 
                            ID 
                        FROM 
                            {$wpdb->posts} 
                        WHERE 
                            post_type = 'attachment' AND 
                            post_mime_type LIKE 'image%' AND 
                            post_parent IN (" . $string_parent_id . ")
                    ", ARRAY_A );

                    foreach ( $attached_id as $key => $value ) {
                        $result_attachment_id_array[] = $value['ID'];
                    }
                    echo json_encode( array_unique( $result_attachment_id_array ) );
                }
                break;
            case 'update_image':
                $metadata   = wp_get_attachment_metadata( $id );
                $uploads    = wp_upload_dir();
                $path       = $uploads['basedir'] . "/" . $metadata['file'];
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $metadata_new = mtst_wp_generate_attachment_metadata( $id, $path, $metadata );
                wp_update_attachment_metadata( $id, array_merge( $metadata, $metadata_new ) );
                break;
            case 'update_options':
                unset( $mtst_options['need_image_update'] );
                update_option( 'mtst_options', $mtst_options );
                break;
        }
        die();
    }
}
 
function true_top_menu_page(){
 
    add_submenu_page(
        'edit.php?post_type=ads',
        __( 'Settings Ads', 'mtst-text-domain' ),
        __( 'Settings Ads', 'mtst-text-domain' ),
        'manage_options',
        'true_ads',
        'true_ads_page_callback'
    );
}
 
function true_ads_page_callback(){
 
    echo '<div class="wrap">
    <h1>' . get_admin_page_title() . '</h1>
    <form method="post" action="options.php">';
 
        settings_fields( 'true_ads_settings' );
        do_settings_sections( 'true_ads' );
        submit_button();
 
    echo '</form></div>';
 
}
 
function true_ads_fields(){
 
    register_setting(
        'true_ads_settings',
        'number_of_ads_a',
        'absint'
    );
 
    add_settings_section(
        'ads_settings_section_id',
        '',
        '',
        'true_ads'
    );
 
    add_settings_field(
        'number_of_ads_a',
        __( 'Message sending time', 'mtst-text-domain' ),
        'true_number_field',
        'true_ads',
        'ads_settings_section_id',
        array( 
            'label_for' => 'number_of_ads_a',
            'class' => 'ads-class',
            'name' => 'number_of_ads_a',
        )
    );
 
}
 
function true_number_field( $args ){
    $value = get_option( $args[ 'name' ] );
 
    printf(
        '<input type="number" min="1" id="%s" name="%s" value="%d" /> min',
        esc_attr( $args[ 'name' ] ),
        esc_attr( $args[ 'name' ] ),
        absint( $value )
    );
 
}

add_action( 'admin_enqueue_scripts', 'mtst_add_admin_iris_scripts' );
add_shortcode( 'list-posts-basic', 'mtst_custom_post_listing_shortcode' );
add_action( 'customize_register', 'mtst_customize_register_action' );
add_action('add_meta_boxes', 'mtst_add_custom_metabox');
add_action( 'init', 'mtst_register_cars_post_type' );
add_action( 'after_setup_theme', 'mtst_setup' );
add_action( 'wp_enqueue_scripts', 'mtst_enqueue_style' );
add_action( 'save_post', 'mtst_save_custom_field' );
add_action( 'wp_ajax_mtst_update_image', 'mtst_update_image' );
add_action('wp_ajax_nopriv_ajax_form', 'ajax_form' );
add_action('wp_ajax_ajax_form', 'ajax_form' );

add_filter( 'template_include', 'my_template' );
add_action( 'admin_menu', 'true_top_menu_page', 25 );
add_action( 'admin_init',  'true_ads_fields' );

