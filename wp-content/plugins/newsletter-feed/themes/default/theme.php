<?php

// Mandatory
global $post;

/*
 * Some variables are already defined:
 *
 * - $posts Contains all the posts (new and old) with the maximum specified on Feed by Mail configuration.
 * - $last_run Is the last time an email was sent and the time value to use to split the posts
 * - $theme_options An array with all theme options
 * - $theme_url Is the absolute URL to the theme folder used to reference images
 * - $theme_subject Will be the email subject if set by this theme
 *
 * Pay attention that on this new version there is no more the user available: the theme is used once to compose the
 * email and then sent to the delivery engine.
 *
 * Refer to http://codex.wordpress.org/Function_Reference/setup_postdata for the post cicle. It MUST be written as
 *
 * foreach($new_posts as $post) { setup_postdata($post)
 *
 */

// Get new an old posts
if ($last_run < 0) {
    list($new_posts, $old_posts) = array_chunk($posts, ceil(count($posts)/2));
} else {
    list($new_posts, $old_posts) = NewsletterModule::split_posts($posts, $last_run);
}
$color = $theme_options['theme_color'];
?><!DOCTYPE html>
<html>
    <head>
        <style type="text/css" media="all">
            a {
                text-decoration: none;
                color: <?php echo $color; ?>;
            }
        </style>
    </head>
    <body style="background-color: #ddd; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 14px; color: #666; margin: 0 auto; padding: 0;">
        <br>
        <table align="center">
            <tr>
                <td style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 14px; color: #666;">
                    <div style="text-align: left; max-width: 500px; border-top: 10px solid <?php echo $color; ?>; border-bottom: 3px solid <?php echo $color; ?>; border-bottom: 1px solid #ddd; background-color: #EFEFEF;">
                        <div style="padding: 10px 20px; color: #000; font-size: 20px;">
                            <?php echo $theme_options['theme_title']; ?>
                        </div>
                        <?php if (!empty($theme_options['theme_subtitle'])) { ?>
                        <div style="padding: 0px 20px 10px 20px; color: #666; font-size: 16px;">
                            <?php echo $theme_options['theme_subtitle']; ?>
                        </div>
                        <?php } ?>
                        <div style="padding: 10px 20px; background-color: #fff; line-height: 18px">

                            <?php echo $theme_options['theme_header']; ?>
                            
                            <?php include WP_PLUGIN_DIR . '/newsletter-feed/themes/default/social.php'; ?>

                            <table>
                                <?php foreach($new_posts as $post) { setup_postdata($post); ?>

                                    <tr>
                                        <td colspan="2">
                                            <a style="text-decoration: none; font-size: 22px; color: <?php echo $color; ?>" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a><br>
                                            <br>
                                        </td>
                                    </tr>
                                    <?php if ($theme_options['theme_thumbnails'] == 'large') { ?>
                                    <tr>
                                        <td colspan="2">
                                           <a href="<?php echo get_permalink(); ?>"><img src="<?php echo NewsletterModule::get_post_image($post->ID, 'large', plugins_url('newsletter-feed') . '/images/blank.png'); ?>" width="450"></a> 
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if ($theme_options['theme_full_post'] == 1) { ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php the_content(); ?>
                                        </td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr>
                                        <?php if ($theme_options['theme_thumbnails'] === '1') { ?>
                                        <td valign="top" style="padding-right: 10px;">
                                            
                                            <a href="<?php echo get_permalink(); ?>"><img src="<?php echo NewsletterModule::get_post_image($post->ID, 'thumbnail', plugins_url('newsletter-feed') . '/images/blank.png'); ?>" width="100" height="100"></a>
                                            
                                        </td>
                                        <td valign="top">
                                            <?php echo preg_replace('/<\\/*p>/i', '', get_the_excerpt()); ?>
                                        </td>
                                        <?php } else { ?>
                                        <td valign="top" colspan="2">
                                            <?php echo preg_replace('/<\\/*p>/i', '', get_the_excerpt()); ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                     <tr>
                                        <td colspan="2">
                                            <br><br>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                <?php } ?>

                            </table>

                            <?php if ($theme_options['theme_old_posts'] == 1 && !empty($old_posts)) { ?>
                            <h4><?php echo $theme_options['theme_old_posts_title']; ?></h4>
                                <table>
                                   <?php foreach($old_posts as $post) { setup_postdata($post); ?>
                                   <tr>
                                       <td valign="top">
                                        <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                                       </td>
                                   </tr>
                                   <?php } ?>
                               </table>
                             <?php } ?>

                            <?php echo $theme_options['theme_footer']; ?>

                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>