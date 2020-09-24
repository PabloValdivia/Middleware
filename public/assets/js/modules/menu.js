function initMenu(e) {
    "use strict";
    let $sidebar_wrapper = e,
        mobile_menu_visible = 0,
        mobile_menu_initialized = false,
        toggle_initialized = false,
        bootstrap_nav_initialized = false;
    
    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
  
    let menu = {
        initRightMenu: debounce(function() {
            if (!mobile_menu_initialized) {
                let $navbar = $('nav').find('.navbar-collapse').children('.navbar-nav'),
                    mobile_menu_content = '',
                    nav_content = $navbar.html(),
                    $nav_content = $(nav_content),
                    navbar_form = $('nav').find('.navbar-form').length !== 0 ? $('nav').find('.navbar-form')[0].outerHTML : null,
                    $navbar_form = $(navbar_form),
                    $sidebar_nav = $sidebar_wrapper.find(' > .nav');

                nav_content = '<ul class="nav navbar-nav nav-mobile-menu">' + nav_content + '</ul>';

                // insert the navbar form before the sidebar list
                $nav_content.insertBefore($sidebar_nav);
                $navbar_form.insertBefore($nav_content);

                // simulate resize so all the charts/maps will be redrawn
                window.dispatchEvent(new Event('resize'));

                mobile_menu_initialized = true;
            } else {
                menu.resetWrapper();
            }
        }, 200),

        resetWrapper: () => {
            if ($(window).width() > 991) {
                // reset all the additions that we made for the sidebar wrapper only if the screen is bigger than 991px
                $sidebar_wrapper.find('.navbar-form').remove();
                $sidebar_wrapper.find('.nav-mobile-menu').remove();

                mobile_menu_initialized = false;
            }
        }
    };
}

function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        let context = this,
            args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout( () => {
            timeout = null;
            if (!immediate) { func.apply(context, args); }
        }, wait);
        if (immediate && !timeout) { func.apply(context, args); }
    };
}

export { initMenu };