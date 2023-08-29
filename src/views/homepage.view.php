<?php if (!get_session_key_value(CONF_SESSION_LOGGED)): ?>

<div class="home_conteiner container p-5">
    <!-- logo -->
    <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="savefavdotcom_logo">

        <!-- basic info -->
    <h1 class="home_title display-1">savefav.com</h1>

    <p class="home_description display-6">Get your bookmarks wherever you are.</p>

    <!-- authentication options -->
    <div class="authentication_options text-center py-3">
        <button type="button" class="login_option_btn btn btn-outline-dark border-2 mx-1"><a href="<?= get_url("/login-page"); ?>">Login</a></button>
        <button type="button" class="register_option_btn btn btn-outline-dark border-2 mx-1"><a href="<?= get_url("/register-page"); ?>">Register</a></button>
    </div>

    <!-- website's image -->
    <p class="display-6">COLOCAR IMAGEM DO SITE</p>
</div>

<?php else: ?>

<nav class="main_nav_container navbar bg-light fixed-top py-3">
    <div class="container align-items-center">
        <div class="user user_info">
            <a href="<?= get_url("/"); ?>">
                <img src="<?= get_url("/assets/images/logo.svg"); ?>" alt="savefavdotcom.com.br" class="header_logo">
            </a>

            <span class="nav_email navbar-brand"><?= get_session_key_value(CONF_SESSION_USER)->user_email; ?></span>
        </div>

        <a href="<?= get_url("/logout-user"); ?>" class="logout_option">Logout</a>
    </div>
</nav>

<?php endif; ?>

