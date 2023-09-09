<?php $userData = get_session_key_value(CONF_SESSION_KEY_USER); ?>

<div class="user_options_container container">
    <!-- navbar -->
    <nav class="navbar bg-light py-3">
        <div class="user_options_nav_container container">

            <!-- basic user info -->
            <div class="user_info d-flex align-items-center">
                <a href="<?= get_url("/"); ?>">
                    <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="user_options_header_logo">
                </a>

                <h1><span class="display-6"><?= get_session_key_value(CONF_SESSION_KEY_USER)->user_email; ?></span> options</h1>
            </div>
        </div>
    </nav>

    <!-- update data forms -->
    <div class="update_user_options">
        <form action="<?= get_url("/update-email"); ?>" method="POST" class="user_options_update_form">
            <input type="text" name="update_user_email" class="form-control update_form_input" value="<?= $userData->user_email; ?>" aria-label="User email" aria-describedby="basic-addon1">

            <button type="submit" class="update_form_btn btn btn-outline-dark">Update Email</button>
        </form>

        <form action="<?= get_url("/update-password"); ?>" method="POST" class="user_options_update_form">
            <input type="password" name="update_user_password" class="form-control update_form_input" placeholder="Update password" aria-label="User password" aria-describedby="basic-addon1">

            <button type="submit" class="update_form_btn btn btn-outline-dark">Update Password</button>
        </form>

        <!-- opening delete account modal button -->
        <button type="button" class="delete_account_button btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete_account_modal">
            Delete account
        </button>

        <!-- delete account modal -->
        <div class="delete_account_modal modal fade" id="delete_account_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure?!</h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete your account? All your favs will be deleted.</p>

                        <a href="<?= get_url("/delete-account"); ?>" class="delete_acocunt_link_modal btn btn-danger">I'm sure I wanna delete my account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
