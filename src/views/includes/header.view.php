<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- importing bootstrap -->
    <link rel="stylesheet" href="<?= get_url("/node_modules/bootstrap/dist/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?= get_url("/node_modules/bootstrap-icons/font/bootstrap-icons.min.css"); ?>">

    <!-- importing default style -->
    <link rel="stylesheet" href="<?= get_url("/assets/styles/css/style.css"); ?>">

    <?php if (!empty($pageData["viewStyle"])) : ?>
        <link rel="stylesheet" href="<?= get_url("/assets/styles/css" . $pageData["viewStyle"]); ?>">
    <?php endif; ?>

    <!-- settings favicon -->
    <link rel="shortcut icon" href="<?= get_url("/favicon.ico"); ?>" type="image/x-icon">

    <title>Savefavdotcom - <?= $pageData["title"]; ?></title>
</head>

<body class="bg-light">
    <div class="copyright_container text-center my-2">
        <span class="copyright">savefavdotcom ® All rights reserved.</span>
    </div>
