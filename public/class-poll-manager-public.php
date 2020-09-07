<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       wpartificial.com
 * @since      1.0.0
 *
 * @package    Poll_Manager
 * @subpackage Poll_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Poll_Manager
 * @subpackage Poll_Manager/public
 * @author     Shapon pal <wpartificial@gmail.com>
 */
class Poll_Manager_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
        add_action( 'wp_ajax_pool_action', array($this, 'pool_action' ));

	}

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function load_dependencies() {

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/poll_manager_display.php';
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Poll_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Poll_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/poll-manager-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Poll_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Poll_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/poll-manager-public.js', array( 'jquery' ), $this->version, false );

        // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
        wp_localize_script( $this->plugin_name, 'sp_poll_obj',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	}

    // Same handler function...
    function pool_action() {
        $id = intval( isset($_POST['id'])? $_POST['id']:'' );
        $key =  isset($_POST['key']) ? $_POST['key']: '' ;
        if ($key ==='' || $id ==='') return 0;
        $val = get_post_meta($id, $key, true);
        if (isset($val)){
            $new = (int) $val;
            update_post_meta ( $id, $key, ($new+1) );
        }else{
            add_post_meta ( $id, $key, 1 );
        }

//        if ( ! add_post_meta( $id, 'fruit', 'banana', true ) ) {
//            update_post_meta ( $id, 'fruit', 'banana' );
//        }
        wp_die();
    }

}
