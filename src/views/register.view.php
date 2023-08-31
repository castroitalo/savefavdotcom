<!-- create CSRF token for authentication -->
<?php create_csrf_token(); ?>

<div class="register_form_container container min-vh-100 d-flex justify-content-center align-items-center">

    <span class="register_title display-4">Register</span>

    <a href="<?= get_url(); ?>">
        <!-- logo -->
        <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_logo">
    </a>

    <!-- failed register feedback -->
    <?php if (has_session_key(CONF_SESSION_KEY_REGISTER_ERROR)): ?>
        <?php render_flash_message(CONF_SESSION_KEY_REGISTER_ERROR, CONF_FLASH_DANGER); ?>
    <?php endif; ?>

    <form action="<?= get_url("/register-user"); ?>" method="POST">
        <div class="form-floating mb-3">
            <input type="hidden" name="csrf_token" class="form-control" id="csrf_token" value="<?= get_csrf_token(); ?>">
        </div>
        <div class="input_register_email mb-3">
            <label for="register_email" class="form-label">Email address</label>
            <input type="email" name="register_email" class="form-control" id="register_email" aria-describedby="email_help">
            <div id="email_help" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="input_password_password mb-3">
            <label for="register_password" class="form-label">Password</label>
            <input type="password" name="register_password" class="form-control" id="register_password" aria-describedby="password_help">
            <div id="password_help" class="form-text">Password must be between 8 and 50 characters.</div>
        </div>
        <button type="submit" class="register_btn btn btn-outline-dark">Submit</button>
    </form>

    <span class="login_page_link">Already have an account? Sign in <a href="<?= get_url("/login-page"); ?>">here</a></span>
</div>
