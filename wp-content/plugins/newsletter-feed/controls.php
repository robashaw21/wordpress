<?php

class NewsletterControls {

    var $data;
    var $action = false;

    function __construct($options = null) {
        if ($options == null) {
            if (isset($_POST['options'])) {
                $this->data = stripslashes_deep($_POST['options']);
            }
        } else {
            $this->data = $options;
        }

        if (isset($_REQUEST['act'])) {
            $this->action = $_REQUEST['act'];
        }
    }

        function merge_defaults($defaults) {
        if ($this->data == null)
            $this->data = $defaults;
        else
            $this->data = array_merge($defaults, $this->data);
    }
    
    /**
     * Return true is there in an asked action is no action name is specified or
     * true is the requested action matches the passed action.
     * Dies if it is not a safe call.
     */
    function is_action($action = null) {
        if ($action == null)
            return $this->action != null;
        if ($this->action == null)
            return false;
        if ($this->action != $action)
            return false;
        if (check_admin_referer('save'))
            return true;
        die('Invalid call');
    }

    function get_value($name) {
        if (!isset($this->data[$name]))
            return null;
        return $this->data[$name];
    }

    /**
     * Show the errors and messages.
     */
    function show() {
        if (!empty($this->errors)) {
            echo '<div class="error">';
            echo $this->errors;
            echo '</div>';
        }
        if (!empty($this->messages)) {
            echo '<div class="updated"><p>';
            echo $this->messages;
            echo '</p></div>';
        }
    }

    function yesno($name) {
        $value = isset($this->data[$name]) ? (int) $this->data[$name] : 0;

        echo '<select style="width: 60px" name="options[' . $name . ']">';
        echo '<option value="0"';
        if ($value == 0)
            echo ' selected';
        echo '>No</option>';
        echo '<option value="1"';
        if ($value == 1)
            echo ' selected';
        echo '>Yes</option>';
        echo '</select>&nbsp;&nbsp;&nbsp;';
    }

    function enabled($name) {
        $value = isset($this->data[$name]) ? (int) $this->data[$name] : 0;

        echo '<select style="width: 100px" name="options[' . $name . ']">';
        echo '<option value="0"';
        if ($value == 0)
            echo ' selected';
        echo '>Disabled</option>';
        echo '<option value="1"';
        if ($value == 1)
            echo ' selected';
        echo '>Enabled</option>';
        echo '</select>';
    }

    function select($name, $options, $first = null) {
        $value = $this->get_value($name);

        echo '<select id="options-' . $name . '" name="options[' . $name . ']">';
        if (!empty($first)) {
            echo '<option value="">' . htmlspecialchars($first) . '</option>';
        }
        foreach ($options as $key => $label) {
            echo '<option value="' . $key . '"';
            if ($value == $key)
                echo ' selected';
            echo '>' . htmlspecialchars($label) . '</option>';
        }
        echo '</select>';
    }

    function value($name) {
        echo htmlspecialchars($this->data[$name]);
    }

    function value_date($name, $show_remaining) {
        $time = $this->get_value($name);

        echo gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
        $delta = $time - time();
        if ($show_remaining && $delta > 0) {
            echo 'Remaining: ';
            $delta = $time - time();
            $days = floor($delta / (24 * 3600));
            $delta = $delta - $days * 24 * 3600;
            $hours = floor($delta / 3600);
            $delta = $delta - $hours * 3600;
            $minutes = floor($delta / 60);

            if ($days > 0)
                echo $days . ' days ';
            echo $hours . ' hours ';
            echo $minutes . ' minutes ';
        }
    }

    function text($name, $size = 20, $placeholder = '') {
        $value = $this->get_value($name);
        echo '<input placeholder="' . htmlspecialchars($placeholder) . '" name="options[' . $name . ']" type="text" size="' . $size . '" value="';
        echo htmlspecialchars($value);
        echo '"/>';
    }

    function text_email($name, $size = 40) {
        $value = $this->get_value($name);
        echo '<input name="options[' . $name . ']" type="email" placeholder="Valid email address" size="' . $size . '" value="';
        echo htmlspecialchars($value);
        echo '"/>';
    }

    function text_url($name, $size = 40) {
        $value = $this->get_value($name);
        echo '<input name="options[' . $name . ']" type="url" placeholder="http://..." size="' . $size . '" value="';
        echo htmlspecialchars($value);
        echo '"/>';
    }

    function hidden($name) {
        $value = $this->get_value($name);
        echo '<input name="options[' . $name . ']" type="hidden" value="';
        echo htmlspecialchars($value);
        echo '"/>';
    }

    function button($action, $label, $function = null) {
        if ($function != null) {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';' . htmlspecialchars($function) . '"/>';
        } else {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';this.form.submit()"/>';
        }
    }

    function button_primary($action, $label, $function = null) {
        if ($function != null) {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';' . htmlspecialchars($function) . '"/>';
        } else {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';this.form.submit()"/>';
        }
    }

    function button_confirm($action, $label, $message = '', $data = '') {
        if (empty($message)) {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.btn.value=\'' . $data . '\';this.form.act.value=\'' . $action . '\';this.form.submit()"/>';
        } else {
            echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.btn.value=\'' . $data . '\';this.form.act.value=\'' . $action . '\';if (confirm(\'' .
            htmlspecialchars($message) . '\')) this.form.submit()"/>';
        }
    }

    function textarea($name, $width = '100%', $height = '50') {
        echo '<textarea class="dynamic" name="options[' . $name . ']" wrap="off" style="width:' . $width . ';height:' . $height . '">';
        echo htmlspecialchars($this->data[$name]);
        echo '</textarea>';
    }

    function checkbox($name, $label = '') {
        if ($label != '')
            echo '<label>';
        echo '<input type="checkbox" id="' . $name . '" name="options[' . $name . ']" value="1"';
        if (!empty($this->data[$name]))
            echo ' checked="checked"';
        echo '/>';
        if ($label != '')
            echo '&nbsp;' . $label . '</label>';
    }

    function init() {
        echo '<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("textarea.dynamic").focus(function() {
            jQuery("textarea.dynamic").css("height", "50px");
            jQuery(this).css("height", "400px");
        });
        jQuery("#tabs").tabs();
    });
</script>
';
        echo '<input name="act" type="hidden" value=""/>';
        echo '<input name="btn" type="hidden" value=""/>';
        wp_nonce_field('save');
    }

    function preferences_select($name = 'preference') {
        $options_profile = get_option('newsletter_profile');

        $lists = array();
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            $lists['' . $i] = '(' . $i . ') ' . $options_profile['list_' . $i];
        }
        $this->select($name, $lists);
    }

    function hours($name) {
        $hours = array();
        for ($i = 0; $i < 24; $i++) {
            $hours['' . $i] = '' . $i;
        }
        $this->select($name, $hours);
    }

    function categories($name = 'category') {
        $categories = get_categories();
        echo '<div class="newsletter-checkboxes-group">';
        foreach ($categories as &$c) {
            echo '<div class="newsletter-checkboxes-item">';
            $this->checkbox($name . '_' . $c->cat_ID, esc_html($c->cat_name));
            echo '</div>';
        }
        echo '<div style="clear: both"></div>';
        echo '</div>';
    }

    function post_types($name = 'post_types') {
        $list = array();
        $post_types = get_post_types(array('public' => true), 'objects', 'and');
        foreach ($post_types as &$post_type) {
            $list[$post_type->name] = $post_type->labels->name;
        }

        $this->checkboxes_group($name, $list);
    }

    function checkboxes_group($name, $values_labels) {
        $value_array = $this->get_value_array($name);

        echo "<div class='newsletter-checkboxes-group'>";
        foreach ($values_labels as $value => $label) {
            echo "<div class='newsletter-checkboxes-item'>";
            echo "<input type='checkbox' id='$name' name='options[$name][]' value='$value'";
            if (array_search($value, $value_array) !== false)
                echo " checked";
            echo '/>';
            if ($label != '')
                echo " <label for='$name'>$label</label>";
            echo "</div>";
        }
        echo "</div><div style='clear: both'></div>";
    }

    function get_value_array($name) {
        if (!isset($this->data[$name]) || !is_array($this->data[$name]))
            return array();
        return $this->data[$name];
    }

    function themes() {
        $list = array();

        $dir = WP_CONTENT_DIR . '/extensions/newsletter-feed/themes';
        $handle = @opendir($dir);

        if ($handle !== false) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..')
                    continue;
                if (!is_file($dir . '/' . $file . '/theme.php'))
                    continue;
                $list[$file] = $file;
            }
            closedir($handle);
        }

        $dir = dirname(__FILE__) . '/themes';
        $handle = @opendir($dir);

        if ($handle !== false) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..')
                    continue;
                if (isset($list[$file]))
                    continue;
                if (!is_file($dir . '/' . $file . '/theme.php'))
                    continue;

                $list[$file] = $file;
            }
            closedir($handle);
        }

        $this->select('theme', $list);
    }

    function theme_options() {
        global $controls;
        
        $path = WP_CONTENT_DIR . '/extensions/newsletter-feed/themes/' . $this->data['theme'] . '/theme-options.php';
        if (is_file($path)) {
            require $path;
            return;
        }
        $path = dirname(__FILE__) . '/themes/' . $this->data['theme'] . '/theme-options.php';
        if (is_file($path)) {
            require $path;
            return;
        }
    }
    
        function wp_editor($name, $settings = array()) {
        wp_editor($this->data[$name], $name, array_merge(array('textarea_name' => 'options[' . $name . ']', 'wpautop' => false), $settings));
    }
    
        function color($name) {
        echo $this->text($name, 10);
    }
     static function print_date($time = null, $now = false, $left = false) {
        if (is_null($time)) {
            $time = time();
        }
        if ($time == false) {
            $buffer = 'none';
        } else {
            $buffer = gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
        }
        if ($now) {
            $buffer .= ' (now: ' . gmdate(get_option('date_format') . ' ' .
                            get_option('time_format'), time() + get_option('gmt_offset') * 3600);
            $buffer .= ')';
        }
        if ($left) {
            $buffer .= ', ' . gmdate('H:i:s', $time - time()) . ' left';
        }
        return $buffer;
    }
    
    static function get_emails() {
        global $wpdb;
            $list = $wpdb->get_results("select * from " . NEWSLETTER_EMAILS_TABLE . " where type='feed' order by id desc", OBJECT);
        if ($wpdb->last_error) {
            return false;
        }
        if (empty($list)) {
            return array();
        }
        return $list;
    }

}

?>
