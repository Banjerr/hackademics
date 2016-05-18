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
  *    require the CPT class
*/
require_once( plugin_dir_path( __FILE__ ) . 'hackCPT.php' );

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
 *    add CPTs as cpt holder
 * TODO hide this from the menu and only have it available on the settings screen
*/
if ( ! function_exists('hackademics_posts') ) {
    // Register Custom Post Type
    function hackademics_posts() {

    	$labels = array(
    		'name'                  => _x( 'Hackademics Posts', 'Post Type General Name', 'hackademics' ),
    		'singular_name'         => _x( 'Hackademics Post', 'Post Type Singular Name', 'hackademics' ),
    		'menu_name'             => __( 'Hackademics Posts', 'hackademics' ),
    		'name_admin_bar'        => __( 'Hackademics Post', 'hackademics' ),
    		'archives'              => __( 'Hackademics Post Archives', 'hackademics' ),
    		'parent_item_colon'     => __( 'Parent Hackademics Post:', 'hackademics' ),
    		'all_items'             => __( 'All Hackademics Posts', 'hackademics' ),
    		'add_new_item'          => __( 'Add New Hackademics Post', 'hackademics' ),
    		'add_new'               => __( 'Add New', 'hackademics' ),
    		'new_item'              => __( 'New Hackademics Post', 'hackademics' ),
    		'edit_item'             => __( 'Edit Hackademics Post', 'hackademics' ),
    		'update_item'           => __( 'Update Hackademics Post', 'hackademics' ),
    		'view_item'             => __( 'View Hackademics Post', 'hackademics' ),
    		'search_items'          => __( 'Search Hackademics Post', 'hackademics' ),
    		'not_found'             => __( 'Not found', 'hackademics' ),
    		'not_found_in_trash'    => __( 'Not found in Trash', 'hackademics' ),
    		'featured_image'        => __( 'Featured Image', 'hackademics' ),
    		'set_featured_image'    => __( 'Set featured image', 'hackademics' ),
    		'remove_featured_image' => __( 'Remove featured image', 'hackademics' ),
    		'use_featured_image'    => __( 'Use as featured image', 'hackademics' ),
    		'insert_into_item'      => __( 'Insert into Hackademics Post', 'hackademics' ),
    		'uploaded_to_this_item' => __( 'Uploaded to this Hackademics Post', 'hackademics' ),
    		'items_list'            => __( 'Hackademics Posts list', 'hackademics' ),
    		'items_list_navigation' => __( 'Hackademics Posts list navigation', 'hackademics' ),
    		'filter_items_list'     => __( 'Filter Hackademics Posts list', 'hackademics' ),
    	);

        $args = array(
    		'label'                 => __( 'Hackademics Post', 'hackademics' ),
    		'description'           => __( 'The Parent Of All Hackademics CPTs', 'hackademics' ),
    		'labels'                => $labels,
    		'supports'              => array( 'title', 'excerpt', 'custom-fields', ),
    		'taxonomies'            => array( 'category', 'post_tag' ),
    		'hierarchical'          => true,
    		'public'                => true,
    		'show_ui'               => true,
    		'show_in_menu'          => true,
    		'menu_position'         => 5,
    		'menu_icon'             => 'dashicons-welcome-learn-more',
    		'show_in_admin_bar'     => true,
    		'show_in_nav_menus'     => true,
    		'can_export'            => true,
    		'has_archive'           => true,
    		'exclude_from_search'   => false,
    		'publicly_queryable'    => true,
    		'capability_type'       => 'page',
    	);
    	register_post_type( 'hack_post', $args );
    }
    add_action( 'init', 'hackademics_posts', 0 );
}

/**
 *    make a start class CPT
*/
function makeADummyClass()
{
    // Create post object
    $hackademics_class = array(
      'post_title'    => 'Class',
      'post_content'  => 'This is the over arching Hackademics post container',
      'post_excerpt'  => 'This is the over arching Hackademics post container',
      'post_status'   => 'draft',
      'post_type'     => 'hack_post'
    );

    // Insert the post into the database
    wp_insert_post( $hackademics_class );
}
// when the plugin is activated, make a dummy post
register_activation_hook( __FILE__, 'makeADummyClass' );

/**
 *    set up the settings page
*/
add_action( 'admin_menu', 'hackademics_add_admin_menu' );
add_action( 'admin_init', 'hackademics_settings_init' );


function hackademics_add_admin_menu(  ) {

	add_menu_page( 'Hackademics', 'Hackademics', 'manage_options', 'hackademics', 'hackademics_options_page', 'dashicons-welcome-learn-more' );

}


function hackademics_settings_init(  ) {

	register_setting( 'pluginPage', 'hackademics_settings' );

	add_settings_section(
		'hackademics_pluginPage_section',
		__( 'This is where you will create and access all Hackademics posts to edit/update them. Check out the documentation to help get you started', 'hackademics' ),// TODO make this link to documentation (probably just a link to github md files?)
		'hackademics_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'hackademics_text_field_0',
		__( 'Pick slug name ', 'hackademics' ),// TODO do something with this? or not
		'hackademics_text_field_0_render',
		'pluginPage',
		'hackademics_pluginPage_section'
	);


}


function hackademics_text_field_0_render(  ) {

	$options = get_option( 'hackademics_settings' );
	?>
	<input type='text' name='hackademics_settings[hackademics_text_field_0]' value='<?php echo $options['hackademics_text_field_0']; ?>'>
	<?php

}


function hackademics_settings_section_callback(  ) {

	echo __( 'This section description', 'hackademics' );

}


function hackademics_options_page(  ) {

	?>
	<form action='options.php' method='post'>

		<h2>Hackademics</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();

        $temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query('post_type=hack_post');
        echo '<section class="hackademics_options">';
            echo '<h2>Hackademics Posts</h2>';
            if($wp_query->have_posts())
            {
                echo "<ul class='hackademics_posts'>";
                while ($wp_query->have_posts()) : $wp_query->the_post();
                    // get that content and stuff
                    echo "<li>";
                        $hack_title = get_the_title();
                        $hack_id = get_the_id();

                        echo '<h3>' . $hack_title . '</h3>';
                        echo '<p>' . get_the_excerpt() . '</p>';

                        // make a CPT from a CPT... CPTception!
                        $hack_id = new Post_Type( $hack_title );

                    echo "</li>";
                endwhile;
                echo '</ul><!-- .hackademics_posts -->';
            }
            else
            {
                echo '<h2>Whoa! It looks like there are no Hackademics posts saved yet. Go save one and get started!</h2>';
            }
        echo '</section><!-- .hackademics_options -->';
        $wp_query = null;
        $wp_query = $temp;  // Reset
		?>

	</form>
	<?php

}

?>
