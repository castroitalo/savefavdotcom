<?php if (!get_session_key_value(CONF_SESSION_KEY_LOGGED)) : ?>

    <?php include CONF_VIEW_ROOT_PATH . "/includes/not_logged_homepage.view.php"; ?>

<?php else : ?>

    <?php include CONF_VIEW_ROOT_PATH . "/includes/logged_homepage.view.php"; ?>

<?php endif; ?>
