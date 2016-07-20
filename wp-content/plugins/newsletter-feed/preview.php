<?php
header('Content-Type: text/html;charset=UTF-8');

include '../../../wp-load.php';

if (!check_admin_referer('preview'))
    wp_die('Invalid nonce key');

$module = NewsletterFeed::$instance;
$email = $module->create_email($module->options, -1);

echo $email['message'];