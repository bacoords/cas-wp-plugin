<?php
/*
Plugin Name: CAS Custom Plugin
Plugin URI: http://briancoords.com
Version: 1.0.0
Author: Brian Coords
Author URI: http://briancoords.com
*/

class PageTemplater {

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new PageTemplater();
                } 

                return self::$instance;

        } 

        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {

                $this->templates = array();


                // Add a filter to the attributes metabox to inject template into the cache.
                add_filter(
					'page_attributes_dropdown_pages_args',
					 array( $this, 'register_project_templates' ) 
				);


                // Add a filter to the save post to inject out template into the page cache
                add_filter(
					'wp_insert_post_data', 
					array( $this, 'register_project_templates' ) 
				);


                // Add a filter to the template include to determine if the page has our 
				// template assigned and return it's path
                add_filter(
					'template_include', 
					array( $this, 'view_project_template') 
				);


                // Add your templates to this array.
                $this->templates = array(
                        'cas-wp-plugin-template.php'     => 'Custom Backend Schools Page',
                );
				
        } 


        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */

        public function register_project_templates( $atts ) {

                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

                // Retrieve the cache list. 
				// If it doesn't exist, or it's empty prepare an array
				$templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                } 

                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');

                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );

                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );

                return $atts;

        } 

        /**
         * Checks if the template is assigned to the page
         */
        public function view_project_template( $template ) {

                global $post;

                if (!isset($this->templates[get_post_meta( 
					$post->ID, '_wp_page_template', true 
				)] ) ) {
					
                        return $template;
						
                } 

                $file = plugin_dir_path(__FILE__). get_post_meta( 
					$post->ID, '_wp_page_template', true 
				);
				
                // Just to be safe, we check if the file exist first
                if( file_exists( $file ) ) {
                        return $file;
                } 
				else { echo $file; }

                return $template;

        } 


} 

add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

add_theme_support('angular-wp-api', array('angular', 'angular-route', 'angular-resource'));
//enqueue scripts


function cas_plugin_enqueue_script() {
  if(is_page_template( 'cas-wp-plugin-template.php')){
    
 	  wp_enqueue_script('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js', array('jquery'));
 	  
    wp_enqueue_script('angular-route', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-route.js', array('angular'));
    
    wp_enqueue_script( 'angular-resource', '//ajax.googleapis.com/ajax/libs/angularjs/1.2.23/angular-resource.min.js', array( 'angular' ) );
    
    wp_enqueue_script( 'cas-plugin-js', 'http://cas.threecordsstudio.com/wp-content/plugins/cas-wp-plugin/cas-wp-plugin.js', array( 'angular','angular-resource','angular-route','angular-wp-api' ) );   
  }

}
add_action( 'wp_enqueue_scripts', 'cas_plugin_enqueue_script' );

function cas_plugin_enqueue_style() {
  if(is_page_template( 'cas-wp-plugin-template.php')){
    wp_enqueue_style( 'cas-plugin-style', 'http://cas.threecordsstudio.com/wp-content/plugins/cas-wp-plugin/dist/css/cas-wp-plugin.css' ); 
  }
}
add_action( 'wp_enqueue_scripts', 'cas_plugin_enqueue_style' );




  /**
  * Add REST API support to an already registered post type.
  */
  add_action( 'init', 'cas_school_post_type_rest_support', 25 );
  function cas_school_post_type_rest_support() {
    global $wp_post_types;

    //be sure to set this to the name of your post type!
    $post_type_name = 'cas_school';
    if( isset( $wp_post_types[ $post_type_name ] ) ) {
        $wp_post_types[$post_type_name]->show_in_rest = true;
        $wp_post_types[$post_type_name]->rest_base = $post_type_name;
        $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
    }

  }




//List of Post Meta
//_cas_school_name', true );
//'_cas_school_subheading', true );
//'_cas_school_mascot', true );
//'_cas_school_colors', true );
//'_cas_school_color_hex', true );
//'_cas_school_poster_program', true );
//'_cas_school_description', true );
//'_cas_school_season_sports', true );
//'_cas_school_info_field_sports', true );
//'_cas_school_address', true );
//'_cas_school_city', true );
//'_cas_school_state', true );
//'_cas_school_zip', true );
//'_cas_school_leads', true );
//'_cas_school_site_url', true );
//'_cas_school_contact_name', true );
//'_cas_school_contact_title', true );
//'_cas_school_contact_phone', true );
//'_cas_school_contact_email', true );
//'_cas_school_logo', true );
//'_cas_school_background', true );
//'_cas_school_previous_posters', true );
//'_cas_school_testimonial_text', true );
//'_cas_school_testimonial_name', true );
//'_cas_school_testimonial_business_name', true );
//'_cas_school_testimonial_business_url', true );
//'_cas_school_testimonial_achievements', true );
//'_cas_school_team_bank_url






add_action( 'rest_api_init', 'cas_plugin_register_custom_meta' );
function cas_plugin_register_custom_meta() {
    register_rest_field( 'cas_school',
        '_cas_school_name',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'cas_school',
        '_cas_school_city',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'cas_school',
        '_cas_school_state',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'cas_school',
        '_cas_school_team_bank_url',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * Get the value of the "starship" field
 *
 * @param array $object Details of current post.
 * @param string $field_name Name of field.
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function cas_plugin_get_custom_meta( $object, $field_name, $request ) {
    return get_post_meta( $object[ 'id' ], $field_name, true );
}

?>
