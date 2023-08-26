<div class="login_form_container container min-vh-100 d-flex justify-content-center align-items-center">

    <!-- logo -->
    <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_logo">

    <div class="alert_login alert alert-danger" role="alert">
        User not found with e-mail mailmtlognoprak7#gmail.com
    </div>

    <form method="POST">

        <div class="input_login_email mb-3">
            <label for="login_email" class="form-label">Email address</label>
            <input type="email" name="login_email" class="form-control" id="login_email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="input_login_password mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="login_btn btn btn-outline-dark">Submit</button>
    </form>
</div>
