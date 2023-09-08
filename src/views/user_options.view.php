<?php $userData = get_session_key_value(CONF_SESSION_KEY_USER); ?>

<div class="user_options_container container">
    <h1><span class="display-6"><?= get_session_key_value(CONF_SESSION_KEY_USER)->user_email; ?></span> options</h1>

    <form action="<?= get_url("/update-data"); ?>" method="POST">
        <div class="mb-3">
            <label for="update_email_input" class="form-label">Update email</label>
            <input type="email" class="form-control" id="update_email_input" value="<?= $userData->user_email ?>">
        </div>
        <div class="mb-3">
            <label for="update_password_input" class="form-label">Update password</label>
            <input type="password" class="form-control" id="update_password_input" placeholder="Update password">
        </div>
        <button type="submit" class="update_data_btn btn btn-outline-dark">Submit</button>
    </form>

    <form action="<?= get_url("/delete-account"); ?>" method="POST" class="my-3">
        <button type="submit" class="btn btn-outline-danger">Delete Account</button>
    </form>
</div>
