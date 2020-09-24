function initSidebar(e) {
    "use strict";
    let $sidebar = e;

    let md = {
        checkSidebarImage: function() {
            let image_src = $sidebar.data('image');

            if (image_src !== undefined) {
            let sidebar_container = '<div class="sidebar-background" style="background-image: url(' + image_src + ') "/>';
            $sidebar.append(sidebar_container);
            }
        },

        initSidebarsCheck: function() {
            if ($(window).width() <= 991) {
            if ($sidebar.length !== 0) {
                md.initRightMenu();
            }
            }
        }
    };
}

export { initSidebar };
