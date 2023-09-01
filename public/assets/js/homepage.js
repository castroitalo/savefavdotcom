jQuery(function ($) {
    $(".fav_search").on("input", function (e) {
        let search = $(this).val().toLowerCase();
        let favList = $(".fav_list_item");

        // Show all fav if search if empty
        if (!search) {
            favList.each(function (index, value) {
                value.style.display = "";
            });
        }

        // Filter fav if search is not empty
        favList.each(function (index, value) {
            let favTitle = value.innerText.toLowerCase();

            if (!favTitle.includes(search)) {
                value.style.display = "none";
            }
        });
    });
});
