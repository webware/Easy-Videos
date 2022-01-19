<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Easy_Videos
 * @subpackage Easy_Videos/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Videos
 * @subpackage Easy_Videos/admin
 * @author     Irshad  
 */
class Easy_Videos_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $easy_videos    The ID of this plugin.
	 */
	private $easy_videos;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;	
	
	
	/**
	 * The youtube channeld ID.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $channelId    The channel ID for which We retrive the data.
	 */
	private $channelId;
    
	
	/**
	 * The Google APIs key.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      int    $api_keys    The unique Google API keys.
	 
	 */
	 
	private $api_keys;
	
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $easy_videos       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $easy_videos, $version, $api_keys ) {
		
			$this->easy_videos = $easy_videos;
			$this->version = $version;
	    	$this->api_keys = $api_keys;
			$this->channelId = 'UCiq1FIgtEK7LRAOB1JXTPig';

	}

	 

	 
	
	/**
	 * Register the video import page.
	 *
	 * @since    1.0.0
	 */
	public function easy_videos_import() {

		/**
		 * This function is used for registering import page under custom post type.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Videos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Videos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		
		
		add_submenu_page('edit.php?post_type=easy-videos', __( 'Easy Import', 'easy-import' ),  __( 'Easy Import', 'easy-import' ),'manage_options','easy-import', array( $this, 'easy_videos_import_callback' ) );

	}
	
	
		/**
		 *
		 * Call back function 
		 *
		 * List youtube videos per channel 
		 * Select videos to import to WP database
		 *
		 */
	 
     
	 
    public function easy_videos_import_callback() {
		 

			   $yt_api_url = "https://www.googleapis.com/youtube/v3/search?key=".$this->api_keys."&channelId=".$this->channelId."&part=snippet,id&order=date&maxResults=10";
			   $yt_json = file_get_contents($yt_api_url);
			
			 
			  if($yt_json){ 
					$videoList = json_decode($yt_json); 
				}else{ 
					echo 'Invalid API key or channel ID.'; 
				}
				
			  if(!empty($videoList->items)){ 
			   echo '<div class="attachments-wrapper"> <ul tabindex="-1" class="attachments ui-sortable ui-sortable-disabled">';
				foreach($videoList->items as $item){ 
					// Embed video 
					if(isset($item->id->videoId)){ 
						echo ' 
						<li tabindex="0" role="checkbox" aria-checked="false" data-id="14" class="attachment save-ready"> 
							<iframe width="280" height="150" src="https://www.youtube.com/embed/'.$item->id->videoId.'" frameborder="0" allowfullscreen></iframe> 
							<h4>'. $item->snippet->title .'</h4> 
						</li>'; 
					} 
				} 
				echo '</div>';
			}else{ 
				echo '<p class="error">'.$apiError.'</p>'; 
			}
			
   }
	
	/**
	* This function is provided for custom post registration.
	* All imported videos will be saved these custom posts
	* 
	*
	*/	
	 
	public function reg_easy_videos_post() {

	
		   $labels = array(
				'name'                  => _x( 'Easy Videos', 'Post type general name', 'easy-videos' ),
				'singular_name'         => _x( 'Easy Video', 'Post type singular name', 'easy-videos' ),
				'menu_name'             => _x( 'Easy Videos', 'Admin Menu text', 'easy-videos' ),
				'name_admin_bar'        => _x( 'Easy Videos', 'Add New on Toolbar', 'easy-videos' ),
				'add_new'               => __( 'Add New', 'easy-videos' ),
				'add_new_item'          => __( 'Add New Video', 'easy-videos' ),
				'new_item'              => __( 'New Video', 'easy-videos' ),
				'edit_item'             => __( 'Edit Video', 'easy-videos' ),
				'view_item'             => __( 'View Video', 'easy-videos' ),
				'all_items'             => __( 'All Videos', 'easy-videos' ),
				'search_items'          => __( 'Search Videos', 'easy-videos' ),
				'parent_item_colon'     => __( 'Parent Videos:', 'easy-videos' ),
				'not_found'             => __( 'No Videos found.', 'easy-videos' ),
				'not_found_in_trash'    => __( 'No Videos found in Trash.', 'easy-videos' ),
				'featured_image'        => _x( 'Video Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'easy-videos' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'easy-videos' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'easy-videos' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'easy-videos' ),
				'archives'              => _x( 'Video archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'easy-videos' ),
				'insert_into_item'      => _x( 'Insert into Video', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'easy-videos' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this Video', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'easy-videos' ),
				'filter_items_list'    => _x( 'Filter Videos list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'easy-videos' ),
				'items_list_navigation' => _x( 'Videos list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'easy-videos' ),
				'items_list'            => _x( 'Videos list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'easy-videos' ),
			);
		 
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'easy-video' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 70,
				'menu_icon'          => 'dashicons-youtube',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'show_in_rest'       => true
			);
		 
			register_post_type( 'easy-videos', $args );
		
		
		

	}
	
		


}
