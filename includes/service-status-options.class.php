<?php

/*
 * @package 	Service_Status_Options
 * @author	Mediaburst Ltd
 * @copyright	2011 Mediaburst Ltd
 * @license	ISC
 * @since	0.1
 */
class Service_Status_Options {
	public $slug;
	public $post_type = "service-status";
	public $statuses; 
	public $comments = false;

	const option_prefix = "service-status-opt-";
	const meta_prefix = "service-status-meta-";
 
	function Service_Status_Options() { 
		$this->__construct();
	}

	function __construct() { 
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		$this->get_options();
		add_action( 'manage_posts_custom_column', array( &$this, 'custom_column' ) );
		add_filter( 'manage_edit-'.$this->post_type.'_columns', array( &$this, 'edit_columns' ) );
	}
	

	public function admin_menu() { 
		if ( function_exists( 'add_options_page' ) ) 
			add_options_page( 'Service Status Options', 'Service Status', 'manage_options', 'service-status', array( &$this, 'options_page' ) );
	}

	public function options_page() {
		include('options-page.php');
	}

	public function get_options() {
		$this->slug = get_option( Service_Status_Options::option_prefix.'slug', 'status' );
		$this->statuses = get_option( Service_Status_Options::option_prefix.'statuses', array() );
		$this->comments = get_option( Service_Status_Options::option_prefix.'comments', false );
	}

	public function save_options() {
		update_option( Service_Status_Options::option_prefix.'slug', $this->slug );
		update_option( Service_Status_Options::option_prefix.'statuses', $this->statuses );
		update_option( Service_Status_Options::option_prefix.'comments', $this->comments ); 
	}

	public function edit_columns($columns) {
		$columns = array(
			'cb' 		=> '<input type="checkbox" />',
			'date' 		=> 'Date',
			'title' 	=> 'Title',
			'status'	=> 'Status'
		);
		return $columns;
	}
	
	public function custom_column($column) { 
		global $post;
		switch($column) {
			case "date": 
				echo get_the_date('j m y H:i');
				break;
			case "description":
				the_title();
				break;
			case "status":
				$id = get_post_meta($post->ID, Service_Status_Options::meta_prefix.'status',true);
				echo $this->statuses[$id]['name'];
				break;
		}
	}
}
