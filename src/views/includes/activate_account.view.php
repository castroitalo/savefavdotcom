<div class="activation_page_container container text-center">
    <!-- failed activate account -->
    <?php if (has_session_key(CONF_SESSION_KEY_FAILED_ACTIVATE_ACCOUNT)): ?>
        <?php render_flash_message(CONF_SESSION_KEY_FAILED_ACTIVATE_ACCOUNT, CONF_FLASH_DANGER); ?>
    <?php endif; ?>

    <!-- fail resent email verification -->
    <?php if (has_session_key(CONF_SESSION_KEY_FAIL_RESENT_ACTIVATION_EMAIL)): ?>
        <?php render_flash_message(CONF_SESSION_KEY_FAIL_RESENT_ACTIVATION_EMAIL, CONF_FLASH_DANGER); ?>
    <?php endif; ?>

    <!-- resent email verification -->
    <?php if (has_session_key(CONF_SESSION_KEY_RESENT_ACTIVATION_EMAIL)): ?>
        <?php render_flash_message(CONF_SESSION_KEY_RESENT_ACTIVATION_EMAIL, CONF_FLASH_INFO); ?>
    <?php endif; ?>

    <div class="alert alert-info text-center" role="alert">
        Activate your Email.
    </div>

    <a href="<?= get_url("/resend-activation-email?email=" . get_session_key_value(CONF_SESSION_KEY_USER)->user_email); ?>" class="btn btn-outline-dark">
        Resend activation email.
    </a>
</div>
