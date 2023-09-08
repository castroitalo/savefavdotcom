<?php if (!get_session_key_value(CONF_SESSION_KEY_LOGGED)) : ?>

    <div class="home_conteiner container p-5">
        <!-- logo -->
        <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_logo">

        <!-- basic info -->
        <h1 class="home_title display-1">savefav.com</h1>

        <p class="home_description display-6">Simple and minimal way to save your favorite sites.</p>

        <!-- authentication options -->
        <div class="authentication_options text-center py-3">
            <button type="button" class="login_option_btn btn btn-outline-dark border-2 mx-1"><a href="<?= get_url("/login-page"); ?>">Login</a></button>
            <button type="button" class="register_option_btn btn btn-outline-dark border-2 mx-1"><a href="<?= get_url("/register-page"); ?>">Register</a></button>
        </div>

        <!-- website's image -->
        <img src="<?= get_url("/assets/images/savefavdotcom-example.png"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_example">
    </div>

<?php else : ?>

    <!-- redirect to activation page -->
    <?php if (get_session_key_value(CONF_SESSION_KEY_USER)->user_active === 0): ?>
        <?php redirectTo(get_url("/activate-page")); ?>
    <?php endif; ?>

    <!-- generate a new CSRF token for new fav post -->
    <?php create_csrf_token(); ?>

    <!-- logged main page -->
    <div class="main_page_container container">

        <!-- navbar -->
        <nav class="main_nav_container navbar bg-light py-3">
            <div class="container align-items-center">

                <!-- basic user info -->
                <div class="user_info">
                    <a href="<?= get_url("/"); ?>">
                        <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="header_logo">
                    </a>

                    <a href="<?= get_url("/user-options"); ?>" class="nav_email navbar-brand"><?= get_session_key_value(CONF_SESSION_KEY_USER)->user_email; ?></a>
                </div>

                <!-- logout -->
                <a href="<?= get_url("/logout-user"); ?>" class="logout_option">Logout</a>
            </div>
        </nav>

        <!-- main content -->
        <div class="main_content">

            <!-- failed to add a new fav -->
            <?php if (has_session_key(CONF_SESSION_KEY_FAILED_TO_ADD_FAV)) : ?>
                <?php render_flash_message(CONF_SESSION_KEY_FAILED_TO_ADD_FAV, CONF_FLASH_DANGER); ?>
            <?php endif; ?>

            <!-- failed to logout -->
            <?php if (has_session_key(CONF_SESSION_KEY_LOGOUT_ERROR)) : ?>
                <?php render_flash_message(CONF_SESSION_KEY_LOGOUT_ERROR, CONF_FLASH_DANGER); ?>
            <?php endif; ?>

            <!-- failed to delete fav -->
            <?php if (has_session_key(CONF_SESSION_KEY_FAILED_TO_DELETE_FAV)) : ?>
                <?php render_flash_message(CONF_SESSION_KEY_FAILED_TO_DELETE_FAV, CONF_FLASH_DANGER); ?>
            <?php endif; ?>

            <!-- search fav and add a new fav option -->
            <div class="user_options d-flex align-items-center">
                <input type="text" class="fav_search form-control" placeholder="Search fav">

                <!-- open new fav modal form -->
                <button type="button" class="new_fav_btn btn btn-success" data-bs-toggle="modal" data-bs-target="#new_fav_modal">
                    <i class="bi bi-bookmark-plus-fill"></i>
                </button>
            </div>
        </div>

        <!-- new fav form modal -->
        <div class="modal fade new_fav_modal" id="new_fav_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Fav</h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- new fav form -->
                        <form action="<?= get_url("/new-fav"); ?>" method="POST">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="csrf_token" class="form-control" id="csrf_token" value="<?= get_csrf_token(); ?>">
                            </div>
                            <div class="input_new_fav_url mb-3">
                                <label for="new_fav_url" class="form-label">Fav URL</label>
                                <input type="text" name="new_fav_url" class="form-control" id="new_fav_url" aria-describedby="new_fav_help">
                                <div id="new_fav_help" class="form-text">URL must match: <strong>http(s)://(www.)sitename.com</strong></div>
                            </div>

                            <button type="submit" class="new_fav_btn btn btn-outline-dark">Add new fav</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- fav list -->
        <?php if (is_string($viewData["user_data"])) : ?>
            <!-- if there is no fav yet -->
            <div class="no_fav_container text-center my-3">
                <span class="no_fav_warning display-6"><?= $viewData["user_data"]; ?></span>
            </div>
        <?php else : ?>
            <ul class="fav_list list-group list-group-flush">
                <!-- user list if favs -->
                <?php foreach ($viewData["user_data"] as $fav) : ?>
                    <li class="fav_list_item list-group-item">
                        <a href="<?= $fav->fav_url; ?>" target="_blank"><?= get_fav_simple_name($fav->fav_url); ?></a>

                        <form action="<?= get_url("/delete-fav"); ?>" method="POST">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="fav_id" class="form-control" id="fav_id" value="<?= $fav->fav_id; ?>">
                            </div>
                            <div class="form-floating mb-3">
                                <input type="hidden" name="csrf_token" class="form-control" id="csrf_token" value="<?= get_csrf_token(); ?>">
                            </div>

                            <button type="submit" class="delete_fav_btn btn btn-danger"><i class="bi bi-bookmark-x-fill"></i></button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

<?php endif; ?>
