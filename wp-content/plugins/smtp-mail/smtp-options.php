<div class="wrap">
    <h1>SMTP邮件发送设置</h1>
    <form method="POST" action="options.php">
        <?php settings_fields('settings-'.SMTP_PLUGIN_FILE); ?>
        <?php do_settings_sections('settings-'.SMTP_PLUGIN_FILE); ?>
        <?php submit_button(); ?>
    </form>
</div>
