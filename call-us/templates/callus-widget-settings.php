<?php
/**
 * Template for the callus widget settings page
 */
?>
<div class="wrap">
    <h1>Callus Widget Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('callus_options_group');
        do_settings_sections('callus_options_group');
        ?>
        <label for="callus_phone_number">Phone Number:</label>
        <input type="text" name="callus_phone_number" value="<?php echo get_option('callus_phone_number'); ?>" />
        <?php submit_button(); ?>
    </form>
</div> 