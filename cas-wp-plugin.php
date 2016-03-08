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
//$name = get_post_meta( get_the_ID(),'_cas_school_name', true );
//$subheading = get_post_meta( get_the_ID(),'_cas_school_subheading', true );
//$mascot = get_post_meta( get_the_ID(),'_cas_school_mascot', true );
//$colors = get_post_meta( get_the_ID(),'_cas_school_colors', true );
//$color_hex = get_post_meta( get_the_ID(),'_cas_school_color_hex', true );
//$progorpost = get_post_meta( get_the_ID(),'_cas_school_poster_program', true );
//$description = get_post_meta( get_the_ID(),'_cas_school_description', true );
//$season_sports = get_post_meta( get_the_ID(),'_cas_school_season_sports', true );
//$info_field_sports = get_post_meta( get_the_ID(),'_cas_school_info_field_sports', true );
//$address = get_post_meta( get_the_ID(),'_cas_school_address', true );
//$city = get_post_meta( get_the_ID(),'_cas_school_city', true );
//$state = get_post_meta( get_the_ID(),'_cas_school_state', true );
//$zip = get_post_meta( get_the_ID(),'_cas_school_zip', true );
//$leads = get_post_meta( get_the_ID(),'_cas_school_leads', true );
//$website_url = get_post_meta( get_the_ID(),'_cas_school_site_url', true );
//$contact_name = get_post_meta( get_the_ID(),'_cas_school_contact_name', true );
//$contact_title = get_post_meta( get_the_ID(),'_cas_school_contact_title', true );
//$contact_phone = get_post_meta( get_the_ID(),'_cas_school_contact_phone', true );
//$contact_email = get_post_meta( get_the_ID(),'_cas_school_contact_email', true );
//$logo = get_post_meta( get_the_ID(),'_cas_school_logo', true );
//$background = get_post_meta( get_the_ID(),'_cas_school_background', true );
//$previous_posters = get_post_meta( get_the_ID(),'_cas_school_previous_posters', true );
//$testimonial_text = get_post_meta( get_the_ID(),'_cas_school_testimonial_text', true );
//$testimonial_name = get_post_meta( get_the_ID(),'_cas_school_testimonial_name', true );
//$testimonial_business_name = get_post_meta( get_the_ID(),'_cas_school_testimonial_business_name', true );
//$testimonial_business_url = get_post_meta( get_the_ID(),'_cas_school_testimonial_business_url', true );
//$testimonial_achievements = get_post_meta( get_the_ID(),'_cas_school_testimonial_achievements', true );







add_action( 'rest_api_init', 'cas_plugin_register_custom_meta' );
function cas_plugin_register_custom_meta() {
    register_rest_field( 'cas_school',
        '_cas_school_name',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta_name',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'cas_school',
        '_cas_school_city',
        array(
            'get_callback'    => 'cas_plugin_get_custom_meta_name',
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
function cas_plugin_get_custom_meta_name( $object, $field_name, $request ) {
    return get_post_meta( $object[ 'id' ], $field_name, true );
}

//function cas_plugin_get_custom_meta_city( $object, $field_name, $request ) {
//    return get_post_meta( $object[ 'id' ], $field_name, true );
//}
//function cas_plugin_get_custom_meta_state( $object, $field_name, $request ) {
//    return get_post_meta( $object[ 'id' ], $field_name, true );
//}

?>