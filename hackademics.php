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
 *    add CPTs as cpt holder
*/
if ( ! function_exists('hackademics_class') ) {
    // Register Custom Post Type
    function hackademics_class() {

    	$labels = array(
    		'name'                  => _x( 'Classes', 'Post Type General Name', 'hackademics' ),
    		'singular_name'         => _x( 'Class', 'Post Type Singular Name', 'hackademics' ),
    		'menu_name'             => __( 'Classes', 'hackademics' ),
    		'name_admin_bar'        => __( 'Class', 'hackademics' ),
    		'archives'              => __( 'Class Archives', 'hackademics' ),
    		'parent_item_colon'     => __( 'Parent Class:', 'hackademics' ),
    		'all_items'             => __( 'All Classes', 'hackademics' ),
    		'add_new_item'          => __( 'Add New Class', 'hackademics' ),
    		'add_new'               => __( 'Add New', 'hackademics' ),
    		'new_item'              => __( 'New Class', 'hackademics' ),
    		'edit_item'             => __( 'Edit Class', 'hackademics' ),
    		'update_item'           => __( 'Update Class', 'hackademics' ),
    		'view_item'             => __( 'View Class', 'hackademics' ),
    		'search_items'          => __( 'Search Class', 'hackademics' ),
    		'not_found'             => __( 'Not found', 'hackademics' ),
    		'not_found_in_trash'    => __( 'Not found in Trash', 'hackademics' ),
    		'featured_image'        => __( 'Featured Image', 'hackademics' ),
    		'set_featured_image'    => __( 'Set featured image', 'hackademics' ),
    		'remove_featured_image' => __( 'Remove featured image', 'hackademics' ),
    		'use_featured_image'    => __( 'Use as featured image', 'hackademics' ),
    		'insert_into_item'      => __( 'Insert into class', 'hackademics' ),
    		'uploaded_to_this_item' => __( 'Uploaded to this class', 'hackademics' ),
    		'items_list'            => __( 'Classes list', 'hackademics' ),
    		'items_list_navigation' => __( 'Classes list navigation', 'hackademics' ),
    		'filter_items_list'     => __( 'Filter classes list', 'hackademics' ),
    	);

        $args = array(
    		'label'                 => __( 'Class', 'hackademics' ),
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
    	register_post_type( 'hack_class', $args );
    }
    add_action( 'init', 'hackademics_class', 0 );
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
      'post_type'     => 'hack_class'
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

	add_menu_page( 'Hackademics', 'Hackademics', 'manage_options', 'hackademics', 'hackademics_options_page' );

}


function hackademics_settings_init(  ) {

	register_setting( 'pluginPage', 'hackademics_settings' );

	add_settings_section(
		'hackademics_pluginPage_section',
		__( 'Your section description', 'hackademics' ),
		'hackademics_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'hackademics_text_field_0',
		__( 'Settings field description', 'hackademics' ),
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
        $wp_query->query('post_type=hack_class');
        if($wp_query->have_posts())
        {
            while ($wp_query->have_posts()) : $wp_query->the_post();
                // get that content and stuff
                echo '<h2>' . get_the_title() . '</h2>';
            endwhile;
        }
        else
        {
            echo '<h2>Whoa! It looks like there are no Hackademics posts saved yet. Go save one and get started!</h2>';
        }
        $wp_query = null;
        $wp_query = $temp;  // Reset
		?>

	</form>
	<?php

}

?>
