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
    );

// Mandatory!
$controls->merge_defaults($theme_defaults);
?>
<p>
    To use this theme you must set a minimum of 10 posts on main configuration. This theme won't generate an email
    if there are less than 3 new posts.
</p>
<table class="form-table">
    <tr valign="top">
        <th>Title</th>
        <td>
            <?php $controls->text('theme_title', 70); ?>
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
</table>
