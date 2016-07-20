<?php
header('Content-Type: text/plain;charset=UTF-8');

include '../../../wp-load.php';

if (!check_admin_referer('preview'))
    wp_die('Invalid nonce key');

$module = NewsletterFeed::$instance;
$email = $module->create_email($module->options, 0);

echo $email['message_text'];