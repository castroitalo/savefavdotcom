jQuery(function ($) {
    /**
     * Check input email
     * @param {object} email jQuery input object
     * @param {object} event mouse click event
     * @returns void
     */
    function checkEmail(email, event) {
        if (email.val() === "") {
            email.addClass("border border-danger");
            event.preventDefault();

            return;
        }
    }

    /**
     * Check input password
     * @param {object} password jQuery input object
     * @param {object} event mouse click event
     * @returns void
     */
    function checkPassword(password, event) {
        if (
            password.val() === "" || 
            password.val().length < 8 || 
            password.val().length > 50
        ) {
            password.addClass("border border-danger");
            event.preventDefault();

            return;
        }
    }

    // Validate login user
    $(".login_btn").on("click", function (e) {
        let $passwordInput = $("#login_password");
        let $emailInput = $("#login_email");

        checkPassword($passwordInput, e);
        checkEmail($emailInput, e);
    });
});
