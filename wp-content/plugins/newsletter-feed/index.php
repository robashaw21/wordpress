<?php
require_once dirname(__FILE__) . '/controls.php';
$module = NewsletterFeed::$instance;
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->data = $module->options;
}
else {

    if ($controls->is_action('reset')) {
        $controls->data = $module->reset_options();
        $controls->messages = 'Options restored.';
    }

    // Force the creartion of a feed by mail email but only if there is something to send.
    if ($controls->is_action('now')) {
        if ($controls->data['enabled'] == 1) {
            $module->delete_transient('run');
            $module->run(true);
            $controls->messages = 'Feed by mail ran: a new email has been created if there was someting to send.';
        }
        else {
            $controls->errors = 'Feed by mail is not enabled, cannot be ran.';
        }
    }

    if ($controls->is_action('save')) {
        // TODO: Remove when this patch is no more needed
        $controls->data['add_new'] = $controls->data['subscription'] == 2?1:0;
        if (!is_numeric($controls->data['max_posts'])) $controls->data['max_posts'] = 10;
        $module->save_options($controls->data);

        wp_clear_scheduled_hook('newsletter_feed');

        // Create the daily event at the specified time
        if ($controls->data['enabled'] == 1) {
            $hour = (int)$controls->data['hour'] - get_option('gmt_offset'); // to gmt
            $day = gmdate("d");
            if (gmdate('G') > $hour) $day++;
            $time = gmmktime($hour, 0, 0, gmdate("m"), $day, gmdate("Y"));
            wp_schedule_event($time, 'daily', 'newsletter_feed');
        }
    }

    if ($controls->is_action('add_all')) {
        $result = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set feed=1 where feed=0");
        $controls->messages = $result . ' subscribers has been activated.';
    }

    if ($controls->is_action('remove_all')) {
        $result = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set feed=0 where feed=1");
        $controls->messages = $result . ' subscribers has been deactivated.';
    }

    if ($controls->is_action('test')) {
        $users = NewsletterUsers::instance()->get_test_users();
        if (empty($users)) {
            $controls->errors = 'No test subscribers found. Mark some subscriber as "test".';
        }
        else {
            $email = $module->create_email($controls->data, -1);
            //$controls->messages .= htmlspecialchars(print_r($email, true));
            Newsletter::instance()->send($email, $users);
            if (!empty($module->create_email_result)) {
                $controls->errors = $module->create_email_result;
            }
            else $controls->messages = 'Test email sent to: ';
            foreach ($users as &$user) $controls->messages .= $user->email . ' ';
        }

    }

    if ($controls->is_action('delete')) {
        $wpdb->query($wpdb->prepare("delete from " . $wpdb->prefix . "newsletter_emails where id=%d", $_POST['btn']));
    }

    if ($controls->is_action('reset_time')) {
        $module->save_last_run(0);
        $controls->messages = 'Reset. On next run all posts are considered as new';
    }

    if ($controls->is_action('back_time')) {
        $module->add_to_last_run(-3600*24);
        $controls->messages = 'Set.';
    }

    if ($controls->is_action('forward_time')) {
        $module->add_to_last_run(3600*24);
        $controls->messages = 'Set.';
    }

    if ($controls->is_action('now_time')) {
        $module->save_last_run(time());
        $controls->messages = 'Set.';
    }
}

$test_users = NewsletterUsers::instance()->get_test_users();
$test_emails = array();
foreach ($test_users as $test_user) {
    $test_emails[] = $test_user->email;
}
?>

<div class="wrap">

    <h2>Newsletter Feed by Mail Extension</h2>

    <div class="updated">
        <p>
            <strong>This is a demo version of the
                <a href="http://www.thenewsletterplugin.com/plugins/newsletter/feed-by-mail-module" target="_blank">Feed by Mail Extension for Newsletter</a>.
                Auto generated emails are sent ONLY to test subscribers</strong>. Generated email are not stored and statistics are not collected.
                <br>
                <strong>Every other option works</strong> so you can collect Feed by Mail subscriptions and once installed the extension start to send
                updates to those subscribers.
                <br>
                <?php if (empty($test_emails)) { ?>
                    <a href="http://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#test" target="_blank">Read more about test subscribers</a>.
                <?php } else { ?>
                    Test subscribers: <?php echo join(', ', $test_emails); ?>.
                <?php } ?>
                    <br><br>
                    <a href="http://www.thenewsletterplugin.com/downloads" target="_blank"><strong>Get the full version now!</strong></a>.


        </p>
    </div>


    <?php $controls->show(); ?>

    <p>
        Here you can configure a feed by mail service. Feed by mail is an automated mailing service which
        sends a mail on a planned hour and day of week with an excerpt of the new
        blog posts published after the previous mail.
    </p>


<form method="post" action="">
    <?php $controls->init(); ?>

        <p>
            <?php $controls->button('save', 'Save'); ?>
            <?php $controls->button('reset', 'Reset'); ?>
            <?php $controls->button('test', 'Test'); ?>
            <?php $controls->button('now', 'Send now!'); ?>
        </p>

        <div id="tabs">

            <ul>
                <li><a href="#tabs-configuration">Configuration</a></li>
                <li><a href="#tabs-2">Theme options</a></li>
                <li><a href="#tabs-3">Preview</a></li>
                <li><a href="#tabs-7">Preview (text)</a></li>
                <li><a href="#tabs-4">New posts</a></li>
                <li><a href="#tabs-5">Emails</a></li>
                <li><a href="#tabs-6">Actions and statistics</a></li>
            </ul>

            <div id="tabs-configuration">

    <table class="form-table">
        <tr valign="top">
            <th>Enabled?</th>
            <td>
                <?php $controls->yesno('enabled'); ?>
                <p class="description">
                    When disabled, no emails will be sent but subscriptions to this service will continue to work.
                </p>
            </td>
        </tr>
        <tr valign="top">
            <th>Service name</th>
            <td>
                <?php $controls->text('name', 50); ?>
                <p class="description">
                    This name is shown on subscription and profile forms so user can subscribe or unsubscribe from it.
                </p>
            </td>
        </tr>

        <tr>
            <th>On subscription...</th>
            <td>
                <?php $controls->select('subscription', array(0=>'Do nothing', 1=>'Show this service option', 2=>'Add it to every new subscriber')); ?>
            </td>
        </tr>

        <tr valign="top">
            <th>Days</th>
            <td>
                Monday&nbsp;<?php $controls->yesno('day_1'); ?>
                Tuesday&nbsp;<?php $controls->yesno('day_2'); ?>
                Wednesday&nbsp;<?php $controls->yesno('day_3'); ?>
                Thursday&nbsp;<?php $controls->yesno('day_4'); ?>
                Friday&nbsp;<?php $controls->yesno('day_5'); ?>
                Saturday&nbsp;<?php $controls->yesno('day_6'); ?>
                Sunday&nbsp;<?php $controls->yesno('day_7'); ?>
                <p class="description">
                    To temporary disable the email sending, set every day to "no".
                </p>
            </td>
        </tr>

        <tr valign="top">
            <th>Delivery hour</th>
            <td>
                <?php $controls->hours('hour'); ?>
            </td>
        </tr>

        <tr valign="top">
            <th>Subject</th>
            <td>
                <?php $controls->text('subject', 50); ?>
                <p class="description">
                    If empty the last post title is used. Use the <code>{date}</code> tag for the current date or <code>{last_post_title}</code>.
                (<a href='http://www.thenewsletterplugin.com/plugins/newsletter/feed-by-mail-module#subject' target='_blank'>Read more about subject generation</a>.
                </p>
            </td>
        </tr>

        <tr valign="top">
            <th>Max posts to extract</th>
            <td>
                <?php $controls->text('max_posts', 5); ?>
            </td>
        </tr>

        <tr valign="top">
            <th>Categories to EXCLUDE</th>
            <td>
                <?php $controls->categories(); ?>
            </td>
        </tr>

         <tr valign="top">
            <th>Post types</th>
            <td>
                <?php if (method_exists($controls, 'post_types')) { ?>
                <?php $controls->post_types(); ?>
                <?php } else { ?>
                WordPress 3.3.0 needed. Please upgrade from your plugin panel.
                <?php } ?>
                <p class="description">
                    Check the post types actually available on your blog that will be included in the periodic email. If none is checked
                    the standard blog posts are used.
                </p>
            </td>
        </tr>

        <tr valign="top">
            <th>Track link clicks?</th>
            <td>
                Trackins is not effective in this demo.
            </td>
        </tr>

    </table>
            </div>


            <div id="tabs-2">
                <table class="form-table">
                    <tr valign="top">
                        <th>Theme</th>
                        <td>
                            <?php $controls->themes(); ?>
                            <?php $controls->button('save', 'Update'); ?>

                            <p class="description">
                                Update to load the new theme and update the previews. Custom themes MUST be added to the
                                <code>wp-content/extensions/newsletter-feed/themes</code> folder.
                                <a href='http://www.thenewsletterplugin.com/plugins/newsletter/newsletter-themes' target='_blank'>Read more on themes</a>.
                            </p>
                        </td>
                    </tr>
                </table>

                <?php $controls->theme_options(); ?>

            </div>


            <div id="tabs-3">

                    <p>
                        This is only a preview to see how the theme will generate emails, it's not the actual email that will be sent
                        next time.
                    </p>

                <iframe src="<?php echo wp_nonce_url(plugins_url('newsletter-feed') . '/preview.php', 'preview'); ?>" width="100%" height="500"></iframe>
            </div>

            <div id="tabs-7">
                    <p>
                        This is only a preview to see how the theme will generate emails, it's not the actual email that will be sent
                        next time.
                    </p>

                <iframe src="<?php echo wp_nonce_url(plugins_url('newsletter-feed') . '/preview-text.php', 'preview'); ?>" width="100%" height="500"></iframe>
            </div>

            <div id="tabs-4">

                    <p>
                        Posts below are the one will be included on next email (sheduled future posts are not counted so
                        more posts could be included).
                    </p>

                <table class="form-table">
                    <tr valign="top">
                        <th>Last sending time</th>
                        <td>
                            <?php echo NewsletterControls::print_date($module->get_last_run()); ?>
                            <?php $controls->button_confirm('reset_time', 'Reset as it never ran', 'Are you sure?'); ?>
                            <?php $controls->button('back_time', 'Back one day'); ?>
                            <?php $controls->button('forward_time', 'Forward one day'); ?>
                            <?php $controls->button('now_time', 'Set to now'); ?>
                            <p class="description">
                                Last time a newsletter has been generated and sent.
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>Generator next run</th>
                        <td>
                            <?php echo NewsletterControls::print_date(wp_next_scheduled('newsletter_feed')); ?>
                            <p class="description">
                                When the newsletter generator runs next time in its daily cycle. Of course on not enabled days it will
                                stop suddenly.
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th>New posts from last sending</th>
                        <td>
                            <?php
                            global $post;
                            $posts = $module->get_posts();
                            list($new_posts, $old_posts) = $module->split_posts($posts, $module->get_last_run());
                            foreach ($new_posts as $post) {
                                setup_postdata($post);
                                ?>
                                [<?php echo the_ID(); ?>] <?php echo NewsletterControls::print_date(NewsletterFeed::m2t($post->post_date_gmt)); ?> <a target="_blank" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a><br />
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>


            <div id="tabs-5">

                <p>
                    This panel shows the autogenerated newsletters, their status (sending, sent, ...) and gives access to each
                    newsletter statistics. Not working on this demo.
                </p>

            </div>


            <div id="tabs-6">
                <?php
                $total_feed = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where feed=1 and status='C'");
                $total = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C'");
                ?>
                <div class="tab-preamble">
                    <p>
                        Here you can run some massive action on subscribers about this service.
                    </p>
                </div>
                <?php $controls->button_confirm('add_all', 'Add this service to all subscribers', 'Proceed?'); ?>
                <?php $controls->button_confirm('remove_all', 'Remove this service from all subscribers', 'Proceed?'); ?>

                <h3>Statistics</h3>
                <p>
                Active subscribers: <?php echo $total_feed; ?> of <?php echo $total; ?>
                </p>
            </div>

        </div>

    <p>
        <?php $controls->button('save', 'Save'); ?>
        <?php $controls->button('reset', 'Reset'); ?>
        <?php $controls->button('test', 'Test'); ?>
        <?php $controls->button_confirm('now', 'Send now!', 'Sure?'); ?>
    </p>


</form>


</div>