<?php
/**
 * event_app functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package event_app
 */
include("inc/cleanwp.php");
if ( ! function_exists( 'event_app_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function event_app_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on event_app, use a find and replace
	 * to change 'event_app' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'event_app', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'event_app' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'event_app_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'event_app_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function event_app_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'event_app_content_width', 800 );
}
add_action( 'after_setup_theme', 'event_app_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function event_app_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'event_app' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'event_app' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'event_app_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function event_app_scripts() {
	wp_enqueue_style( 'event_app-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'event_app_scripts' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function event_app_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'event_app_pingback_header' );

//Remove unwanted JQuery
function my_init() {
    if (!is_admin()) {
        //wp_deregister_script('jquery');
        //wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js', false, '2.2.4', true);
        //wp_enqueue_script('jquery');

        // load additional JS files
        //wp_enqueue_script('site_js', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    }
}
add_action('init', 'my_init');
// Custom Scripting to Move JavaScript from the Head to the Footer
function remove_head_scripts() { 
   remove_action('wp_head', 'wp_print_scripts'); 
   remove_action('wp_head', 'wp_print_head_scripts', 9); 
   remove_action('wp_head', 'wp_enqueue_scripts', 1);

   //add_action('wp_footer', 'wp_print_scripts', 5);
   add_action('wp_footer', 'wp_enqueue_scripts', 5);
   add_action('wp_footer', 'wp_print_head_scripts', 5); 
} 
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );
// END Custom Scripting to Move JavaScript
function prefix_add_footer_styles() {
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/wing.css?p='.time() );
};
add_action( 'get_footer', 'prefix_add_footer_styles' );
// Register Custom Post Type
function custom_local() {

	$labels = array(
		'name'                  => _x( 'Locais', 'Post Type General Name', 'event_app' ),
		'singular_name'         => _x( 'Local', 'Post Type Singular Name', 'event_app' ),
		'menu_name'             => __( 'Locais', 'event_app' ),
		'name_admin_bar'        => __( 'Locais', 'event_app' ),
		'archives'              => __( 'arquivo de locais', 'event_app' ),
		'attributes'            => __( 'Atributos', 'event_app' ),
		'parent_item_colon'     => __( 'Parent Item:', 'event_app' ),
		'all_items'             => __( 'Todos os locais', 'event_app' ),
		'add_new_item'          => __( 'Adicionar local', 'event_app' ),
		'add_new'               => __( 'Adicionar', 'event_app' ),
		'new_item'              => __( 'Novo local', 'event_app' ),
		'edit_item'             => __( 'Editar local', 'event_app' ),
		'update_item'           => __( 'Atualizar', 'event_app' ),
		'view_item'             => __( 'Ver', 'event_app' ),
		'view_items'            => __( 'Ver', 'event_app' ),
		'search_items'          => __( 'Procurar', 'event_app' ),
		'not_found'             => __( 'Não encontrado', 'event_app' ),
		'not_found_in_trash'    => __( 'Não encontrado na lixeira', 'event_app' ),
		'featured_image'        => __( 'Imagem destacada', 'event_app' ),
		'set_featured_image'    => __( 'Configure imagem', 'event_app' ),
		'remove_featured_image' => __( 'Remover imagem', 'event_app' ),
		'use_featured_image'    => __( 'Usar imagem', 'event_app' ),
		'insert_into_item'      => __( 'Inserir', 'event_app' ),
		'uploaded_to_this_item' => __( 'Publicar nesse local', 'event_app' ),
		'items_list'            => __( 'Lista de locais', 'event_app' ),
		'items_list_navigation' => __( 'Items list navigation', 'event_app' ),
		'filter_items_list'     => __( 'Filter items list', 'event_app' ),
	);
	$args = array(
		'label'                 => __( 'Local', 'event_app' ),
		'description'           => __( 'Local da atração', 'event_app' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'local', $args );

}
add_action( 'init', 'custom_local', 0 );
add_action( 'init', 'build_taxonomies', 0 );  
function build_taxonomies() {  
    register_taxonomy(  
		'tipo_local',  
		'local',  // this is the custom post type(s) I want to use this taxonomy for
		array(  
			'hierarchical' => true,  
			'label' => 'Tipos',  
			'query_var' => true,  
			'rewrite' => true  
		)  
	);  
    register_taxonomy(  
		'tag_local',  
		'local',  // this is the custom post type(s) I want to use this taxonomy for
		array(  
			'hierarchical' => false,  
			'label' => 'Tags',  
			'query_var' => true,  
			'rewrite' => true  
		)  
	);  
}
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Eventos';
    $submenu['edit.php'][5][0] = 'Eventos';
    $submenu['edit.php'][10][0] = 'Adicionar Eventos';
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Eventos';
        $labels->singular_name = 'Evento';
        $labels->add_new = 'Adicionar Evento';
        $labels->add_new_item = 'Adicionar Evento';
        $labels->edit_item = 'Editar Eventos';
        $labels->new_item = 'Evento';
        $labels->view_item = 'Ver Evento';
        $labels->search_items = 'Procurar Eventos';
        $labels->not_found = 'Nenhum evento encontrado';
        $labels->not_found_in_trash = 'Nada na lixeira';
    }
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyAJvJGg1Z57TillQjND1FDiuqWlcYvt1Vs');
}

add_action('acf/init', 'my_acf_init');	
// add the namespace to the RSS opening element
function add_media_namespace() {
  echo "xmlns:media=\"http://search.yahoo.com/mrss/\"\n";
}

// add the requisite tag where a thumbnail exists
function add_media_thumbnail() {
  global $post;
  if( has_post_thumbnail( $post->ID )) {
    $thumb_ID = get_post_thumbnail_id( $post->ID );
    $details = wp_get_attachment_image_src($thumb_ID, 'large');
    if( is_array($details) ) {
      echo '<media:thumbnail url="' . $details[0]
        . '" width="' . $details[1] 
        . '" height="' . $details[2] . '" />';
    }
  }
}

// add the two functions above into the relevant WP hooks
add_action( 'rss2_ns', 'add_media_namespace' );
add_action( 'rss2_item', 'add_media_thumbnail' );
function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'local');
	return $qv;
}
add_filter('request', 'myfeed_request');
function feedFilter($query) {
    if ($query->is_feed) {
        //$query->set('order','ASC');
        $query->set('orderby','rand');
        }
    return $query;
}
add_filter('pre_get_posts','feedFilter');