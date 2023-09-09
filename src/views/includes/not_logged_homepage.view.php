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
