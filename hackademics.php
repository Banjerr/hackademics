<?php
/**
 * Plugin Name: Hackademics
 * Version: 0.1-alpha
 * Description: A developer friendly Wordpress learning management plugin
 * Author: Ben Redden
 * Author URI: http://countryfriedcoders.me
 * Plugin URI: http://countryfriedcoders.me
 * Text Domain: hackademics
 * Domain Path: /languages
 * @package Hackademics
 */

/**
 *  add enrolled hackademics stuff to user profile
*/

function addEnrolledHackademicsField( $user ) { ?>

    <h3>Hackademics</h3>

    <table class="form-table">

        <tr>
            <th><label for="enrolledHackademics">Enrolled in...</label></th>

            <td>
                <?php
                $enrolledHackademics = get_the_author_meta( 'enrolledHackademics', $user->ID, true );
                $prettyEnrolledHackademics = implode(', ', $favedPosts);
                ?>
                <input type="text" name="enrolledHackademics" id="enrolledHackademics" value="<?php echo $prettyEnrolledHackademics; ?>" class="regular-text" /><br />
                <span class="description">List of classes currently enrolled in...</span>
            </td>
        </tr>

    </table>
<?php }
add_action( 'show_user_profile', 'addEnrolledHackademicsField' );
add_action( 'edit_user_profile', 'addEnrolledHackademicsField' );

/**
 *  Set Up The Post Type Class
*/

 class hackademics_post
 {
     protected $textdomain;
     protected $post;

     public function __construct( $textdomain )
     {
         $this->textdomain = $textdomain;

         $this->posts = array();

         add_action( 'init', array(&$this, 'register_custom_post' ) );
     }

     public function register_custom_post()
     {
         foreach($this->posts as $key=>$value)
         {
             register_post_type( $key, $value );
         }
     }

     public function make( $type, $singular_label, $plural_label, $settings = array() )
     {
		// Define the default settings
		$default_settings = array(
			'labels' => array(
				'name' => __($plural_label, $this->textdomain),
				'singular_name' => __($singular_label, $this->textdomain),
				'add_new_item' => __('Add New '.$singular_label, $this->textdomain),
				'edit_item'=> __('Edit '.$singular_label, $this->textdomain),
				'new_item'=>__('New '.$singular_label, $this->textdomain),
				'view_item'=>__('View '.$singular_label, $this->textdomain),
				'search_items'=>__('Search '.$plural_label, $this->textdomain),
				'not_found'=>__('No '.$plural_label.' found', $this->textdomain),
				'not_found_in_trash'=>__('No '.$plural_label.' found in trash', $this->textdomain),
				'parent_item_colon'=>__('Parent '.$singular_label, $this->textdomain),
				),
			'public'=>true,
			'has_archive' => true,
			'menu_position'=>20,
			'supports'=>array(
				'title',
				'editor',
				'thumbnail'
				),
			'rewrite' => array(
				'slug' => sanitize_title_with_dashes($plural_label)
				)
			);
		// Override any settings provided by user
		// and store the settings with the posts array
		$this->posts[$type] = array_merge($default_settings, $settings);
    }
 }
