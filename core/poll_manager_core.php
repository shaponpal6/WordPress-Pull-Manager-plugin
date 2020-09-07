<?php


class poll_manager_core
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'acb_configuration_page'));
        //add_action('admin_init', array($this, 'acb_admin_init'));
        add_action('wp_ajax_sp_poll_admin_ajax', array($this, 'sp_poll_admin_ajax'));

        if ((isset($_GET['sp_poll_add']) && $_GET['sp_poll_add'] == 'poll')){
            $this->polling();
        }
    }

    /**
     * Add options page
     */
    public function acb_configuration_page()
    {
        add_menu_page(
            __('Poll Mmanager', 'textdomain'),
            'Poll Mmanager',
            'manage_options',
            'sp_poll_manager',
            array($this, 'add_poll'),
            'dashicons-image-filter',
            26
        );
        add_submenu_page(
            'sp_poll_manager',
            __('Add Poll', 'textdomain'),
            __('Add Poll', 'textdomain'),
            'manage_options',
            'sp_poll_manager_add',
            array($this, 'add_poll')
        );

    }




    /**
     * Options page callback
     */

    function add_poll()
    {
        // Set class property
//        $this->options = get_option('acb_config_options');
        ?>
        <div class="wrap">
            <h1>Add Poll</h1>
            <?php settings_errors(); ?>
            <!--  Show Manage option Page here-->
            <?php require_once 'options/add_poll.php'; ?>
        </div>
        <?php
    }


    function sp_poll_admin_ajax(){
        $polls =  isset($_POST['polls']) ? $_POST['polls']: '' ;
        if (polls === '' ) return 0;
        $val = get_option('sp_poll_manager_questions');
        if (isset($val) && $val != ''){
            update_option ( 'sp_poll_manager_questions', $polls );
        }else{
            add_option ( 'sp_poll_manager_questions', $polls, '', true );
        }

//        header( "Content-Type: application/json" );
//        echo json_encode(get_option('sp_poll_manager_questions'));

        //Don't forget to always exit in the ajax function.
        exit();

    }

    function polling(){
        $polls =  isset($_POST['polls']) ? $_POST['polls']: '' ;
        if (polls === '' ) return 0;
        $val = get_option('sp_poll_manager_questions');
        if (isset($val) && $val != ''){
            update_option ( 'sp_poll_manager_questions', $polls );
        }else{
            add_option ( 'sp_poll_manager_questions', $polls, '', true );
        }
    }


}

if (is_admin())
    return new poll_manager_core();