    <!-- importing bootstrap javascript -->
    <script src="<?= get_url("/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"); ?>"></script>

    <!-- importing jQuery -->
    <script src="<?= get_url("/assets/js/jQuery/jquery-3.7.0.min.js"); ?>"></script>

    <!-- import content js file -->
    <?php if (!empty($pageData["viewScript"])) : ?>
        <script src="<?= get_url("/assets/js" . $pageData["viewScript"]); ?>"></script>
    <?php endif; ?>
</body>

</html>
