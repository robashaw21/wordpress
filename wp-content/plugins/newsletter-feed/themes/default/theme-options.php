<?php
/*
 * This is a pre packaged theme options page. Every option name
 * must start with "theme_" so Newsletter can distinguish them from other
 * options that are specific to the object using the theme.
 *
 * An array of theme default options should always be present and that default options
 * should be merged with the current complete set of options as shown below.
 *
 * Every theme can define its own set of options, the will be used in the theme.php
 * file while composing the email body. Newsletter knows nothing about theme options
 * (other than saving them) and does not use or relies on any of them.
 *
 * For multilanguage purpose you can actually check the constants "WP_LANG", until
 * a decent system will be implemented.
 */
$theme_defaults = array(
    'theme_title'=>get_option('blogname'),

    'theme_header'=>'<p>You\'re receiving this email because you subscribed it at ' . get_option('blogname') .
        ' as {email}. To read this email online <a href="{email_url}">click here</a>. To modify your subscription <a href="{profile_url}">click here</a>.</p>',

    'theme_footer'=>'<p>Yours, ' . get_option('blogname') . '.</p><p>To modify your subscription, <a href="{profile_url}">click here</a>.',

    'theme_color' =>'#0088cc',
    'theme_max_posts' => '10',
    'theme_full_post' => '0',
    'theme_old_posts' => '1',
    'theme_old_posts_title' => 'Older posts you may have missed',
    );

if (!empty($controls->data['theme_email_url'])) {
    $controls->data['theme_header'] = '<p>' . $controls->data['theme_email_url'] . '</p>';
}

if (!empty($controls->data['theme_preamble'])) {
    $controls->data['theme_header'] .= $controls->data['theme_preamble'];
}

if (!empty($controls->data['theme_profile_url'])) {
    $controls->data['theme_footer'] = '<p>' . $controls->data['theme_profile_url'] . '</p>';
}

// Mandatory!
$controls->merge_defaults($theme_defaults);
?>
<table class="form-table">
    <tr valign="top">
        <th>Title</th>
        <td>
            <?php $controls->text('theme_title', 70); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Pay off</th>
        <td>
            <?php $controls->text('theme_subtitle', 70); ?>
        </td>
    </tr>    
    <tr valign="top">
        <th>Header message</th>
        <td>
            <?php $controls->wp_editor('theme_header'); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Footer message</th>
        <td>
            <?php $controls->wp_editor('theme_footer'); ?>
        </td>
    </tr>
    <tr>
        <th>Base color</th>
        <td>
            <?php $controls->color('theme_color'); ?>
            <p class="description">
                A main color tone to skin the neutral theme with your main blog color.
            </p>
        </td>
    </tr>
    <tr>
        <th>How to show posts</th>
        <td>
            <?php $controls->select('theme_full_post', array(0=>'Excerpt', 1=>'Full content')); ?>
            <p class="description">
                Warning: plugins or themes that "inject" things on top or bottom of posts' content
                could make the resultinf message not well formatted.
            </p>
        </td>
    </tr>
    <tr>
        <th>Show post thumbnails/images</th>
        <td><?php $controls->select('theme_thumbnails', array('0'=>'None', '1'=>'Thumbnail', 'large'=>'Large version')); ?></td>
    </tr>
    <tr>
        <th>Show old posts</th>
        <td>
            <?php $controls->yesno('theme_old_posts'); ?><br>
            List title: <?php $controls->text('theme_old_posts_title', 60); ?>
            <p class="description">
                The theme shows a light list of previous posts below the main content. You can disable it.
            </p>
        </td>
    </tr>    
</table>

<h3>Social icons</h3>
<table class="form-table">
    <tr>
        <th>Social block</th>
        <td><?php $controls->checkbox('theme_social_disable'); ?> Disable</td>
    </tr>
    <tr>
        <th>Facebook</th>
        <td><?php $controls->text_url('theme_facebook', 30); ?></td>
    </tr>
    <tr>
        <th>Twitter</th>
        <td><?php $controls->text_url('theme_twitter', 30); ?></td>
    </tr>
    <tr>
        <th>Pinterest</th>
        <td><?php $controls->text_url('theme_pinterest', 30); ?></td>
    </tr>
    <tr>
        <th>Google+</th>
        <td><?php $controls->text_url('theme_googleplus', 30); ?></td>
    </tr>
    <tr>
        <th>LinkedIn</th>
        <td><?php $controls->text_url('theme_linkedin', 30); ?></td>
    </tr>
    <tr>
        <th>Tumblr</th>
        <td><?php $controls->text_url('theme_tumblr', 30); ?></td>
    </tr>
    <tr>
        <th>YouTube</th>
        <td><?php $controls->text_url('theme_youtube', 30); ?></td>
    </tr>
</table>
