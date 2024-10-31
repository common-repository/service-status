<?php
include('service-status-options.class.php');
/*
 * @package 	Service_Status
 * @author	Mediaburst Ltd
 * @copyright	2011 Mediaburst Ltd
 * @license	ISC
 * @since	0.1
 */
class Service_Status { 
	var $options;

	function Service_Status() {
		$this->__construct();
	}

	function __construct() {
		$this->options = new Service_Status_Options();
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'save_post', array( &$this, 'save_post' ) );
		add_shortcode( 'service-status-name', array( &$this, 'status_name_shortcode' ) );
		add_shortcode( 'service-status-desc', array( &$this, 'status_description_shortcode' ) );
	}

	public function init() { 
		$this->register_post_type();
		$this->register_taxonomy();
	}

	public function admin_init() {
		add_meta_box("service-status-meta", "Status", array( &$this, 'post_status' ), $this->options->post_type, "side", "low");
	}

	private function register_post_type() {
		$supports = array('title','editor');
		if( $this->options->comments ) {
			array_push( $supports, 'comments' );
		}
		register_post_type( $this->options->post_type,
                        array(
                                'labels'=> array(
                                        'name'=>__('Service Status'),
                                        'singular_name'=> __('Service Status update'),
                                        'add_new_item'=>__('Add new service status update'),
					'edit_item' => __('Edit status update'),
                                ),
                        	'public'=>true,
	                        'has_archive'=>true,
	                        'rewrite'=>array(
                                        'slug'=>$this->options->slug,
                                        'with_front'=>false,
                                ),
                	        'exclude_from_search'=>true,
				'supports'=> $supports
                        )
                );
	}

	private function register_taxonomy () {
		register_taxonomy( "products", 
			array( $this->options->post_type ), 
			array(
				"hierarchical" => false, 
				"label" => "Products", 
				"singular_label" => "Product", 
				"rewrite" => array('slug', 'product-status')
			)
		);
	}

	public function post_status() {
		global $post;
		$current_status = get_post_meta($post->ID, Service_Status_Options::meta_prefix.'status',true);
		?>
		<p><label for="service-status-status">Status:</label><br />
		<select name="service-status-status" id="service-status-status">
			<?php
			foreach ($this->options->statuses as $key => $status) {
				echo ( $current_status == $key ) ? '<option selected="selected"' : '<option';
				echo ' value="'.$key.'">'.$status['name'].'</option>';
			}
			?>
		</select>
		</p>
		<?php
	}

	public function save_post() {
		global $post;
		if ( isset( $_POST['service-status-status'] ) ) {
			update_post_meta($post->ID, Service_Status_Options::meta_prefix.'status', $_POST['service-status-status']);
		}
	}

	public function status_name_shortcode() {
		$posts = get_posts( array(
				'numberposts'	=> 1,
				'post_type'	=> $this->options->post_type
			) );
		if( count($posts) > 0) {
			$status = get_post_meta($posts[0]->ID, Service_Status_Options::meta_prefix.'status',true);
			return $this->options->statuses[$status]['name'];
			
		}
	}

	public function status_description_shortcode() {
                $posts = get_posts( array(
                                'numberposts'   => 1,
                                'post_type'     => $this->options->post_type
                        ) );
                if( count($posts) > 0) {
                        $status = get_post_meta($posts[0]->ID, Service_Status_Options::meta_prefix.'status',true);
			return $this->options->statuses[$status]['desc'];
                }
        }


	public function current_status() {
		$ss = new Service_Status();
		return $ss->status_name_shortcode();	
	}

	public function current_status_description() {
                $ss = new Service_Status();
                return $ss->status_description_shortcode();
        }

}
