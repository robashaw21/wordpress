<?php
/*
Plugin Name: Email on Publish
Plugin URI: http://yourdomain.com/
Description: Used to email text of post when it is published.
Version: 1.5
Author: Don Kukral
Author URI: http://yourdomain.com
License: GPL
*/
define( 'EMAIL_ON_PUBLISH_URL' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
define( 'EMAIL_ON_PUBLISH_PAGE', 'email_on_publish');

add_action('publish_post', 'email_post');
add_action('admin_menu', 'email_on_publish_admin_menu');

add_action('admin_enqueue_scripts', 'email_publish_admin_scripts');
add_action( 'admin_print_styles', 'email_publish_admin_styles' );

function email_publish_admin_scripts() {
    if ((array_key_exists('page', $_GET)) && ($_GET['page'] == EMAIL_ON_PUBLISH_PAGE)) {
	    wp_enqueue_script("email-on-publish-js", EMAIL_ON_PUBLISH_URL . "js/jquery.validate.min.js", array('jquery'), '1.1');	
    }    
}

function email_publish_admin_styles() {
    if ((array_key_exists('page', $_GET)) && ($_GET['page'] == EMAIL_ON_PUBLISH_PAGE)) {
	    wp_enqueue_style( 'export_posts-css', EMAIL_ON_PUBLISH_URL . 'css/email_on_publish.css', false );
    }
}

function email_post($post_id) {
	$sent = get_post_meta($post_id, 'email_on_publish_sent', True);
	$rules = unserialize(get_option('email_on_publish'));
    foreach(range(1,10) as $n) {
        if (!empty($rules["email-$n"])) {
            $address = $rules["email-$n"];
    		$post = get_post($post_id);
    		$content = $post->post_content;
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Skydive K-State <info@skydivekstate.com>' . "\r\n";

            if (!empty($rules["subject-$n"])) {
    		    $subject = $rules["subject-$n"] . ": " . $post->post_title;
		    } else {
		        $subject = $post->post_title;
		    }
            
		    $send = False;
            if (in_category($rules["cat-$n"], $post_id) || ($rules["cat-$n"] == 0)   ||
                (post_is_in_descendant_category($rules["cat-$n"], $post_id))) {
                
                # its a post we need to deal with
                if (!$sent) {
                    $send = True;
                } elseif ($rules["type-$n"] == "new_and_updated") {
                    $send = True;
                } else {
                    $send = False;
                }
            }

            if ($send) {
    		    mail($address, $subject, $content, $headers);		
    		    update_post_meta($post_id, 'email_on_publish_sent', True);
    	    }
	    }
    }
}

function email_on_publish_admin_menu() {
	add_options_page('Email On Publish', 'Email On Publish', 'administrator', 
		'email_on_publish', 'email_on_publish_settings_page');
}

function email_on_publish_settings_page() {
    if ( isset($_POST['action']) && $_POST['action'] == 'update' ) {
		echo '<div class="updated"><p>Email On Publish Settings Updated</p></div>';
		$post = serialize($_POST);
        update_option('email_on_publish', $post);
        $values = $_POST;
	} else {
        $values = unserialize(get_option('email_on_publish'));
    }
?>
    <div id="content" class="narrowcolumn">

	    <div class="wrap">
	        <h2>Email on Publish</h2>
	        <form method="post" action="" id="email_on_publish_form">
	        <input type="hidden" name="action" value="update" />
            
	        <?php wp_nonce_field('update-options'); ?>
            
                <table class="form-table">
                    <tr>
                    <th class="bold">Rule Name</th>
                    <th class="bold">Email Address</th>
                    <th class="bold">Category</th>
                    <th class="bold">Email Type</th>
                    <th class="bold">Prepend Subject</th>
                    </tr>
                    <?php foreach(range(1,10) as $n) { 
                    $s_cat = $values["cat-$n"];
                    $a = "show_option_all=All+Categories&show_count=1&hierarchical=1&selected=$s_cat&name=cat-$n";
                    ?>
                    <tr>
                    <td><input type="text" name="rule-<?php echo $n ?>" size="20" class="rule" value="<?php echo $values["rule-$n"] ?>"/></td>
                    <td><input type="text" name="email-<?php echo $n ?>" size="25" class="email" value="<?php echo $values["email-$n"] ?>"/></td>
                    <td><?php wp_dropdown_categories($a); ?></td>
                    <td>
                        <select name="type-<?php echo $n ?>">
                            <option value="new_only" <?php selected($values["type-$n"], "new_only"); ?>>New Posts Only</option>
                            <option value="new_and_updated" <?php selected($values["type-$n"], "new_and_updated"); ?>>New and Updated Posts</option>
                        </select>
                    </td>
                    <td><input type="text" name="subject-<?php echo $n ?>" size="20" value="<?php echo $values["subject-$n"] ?>"/></td>
                    </tr>
                    <?php } ?>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="center">
                    <input type="submit" value="Save Email on Publish Rules" class="large"/>
                    </td>
                </table>
                
            </form>
        </div>
    </div>
                    
    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(document).ready(function(){        
            jQuery("#email_on_publish_form").validate();
        });    
    </script>
<?php	
}
    /**
     * Tests if any of a post's assigned categories are descendants of target categories
     *
     * @param int|array $cats The target categories. Integer ID or array of integer IDs
     * @param int|object $_post The post. Omit to test the current post in the Loop or main query
     * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
     * @see get_term_by() You can get a category by name or slug, then pass ID to this function
     * @uses get_term_children() Passes $cats
     * @uses in_category() Passes $_post (can be empty)
     * @version 2.7
     * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
     */
     
    if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
    	function post_is_in_descendant_category( $cats, $_post = null ) {
    		foreach ( (array) $cats as $cat ) {
    			// get_term_children() accepts integer ID only
    			$descendants = get_term_children( (int) $cat, 'category' );
    			if ( $descendants && in_category( $descendants, $_post ) )
    				return true;
    		}
    		return false;
    	}
    }
?>