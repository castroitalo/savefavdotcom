<div class="login_form_container container min-vh-100 d-flex justify-content-center align-items-center">

    <a href="<?= get_url(); ?>">
        <!-- logo -->
        <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_logo">
    </a>

    <!-- failed login feedback -->
    <?php if (has_session_key("login_error")) : ?>
        <div class="alert_login alert alert-danger" role="alert">
            <?= get_session_key_value("login_error"); ?>
        </div>
    <?php endif; ?>

    <form action="<?= get_url("/login"); ?>" method="POST">
        <div class="input_login_email mb-3">
            <label for="login_email" class="form-label">Email address</label>
            <input type="email" name="login_email" class="form-control" id="login_email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="input_login_password mb-3">
            <label for="login_password" class="form-label">Password</label>
            <input type="password" name="login_password" class="form-control" id="login_password">
        </div>
        <button type="submit" class="login_btn btn btn-outline-dark">Submit</button>
    </form>
</div>
