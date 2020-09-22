<?php
    require(VNDPH . 'smarty/libs/Smarty.class.php');

    $html = new Smarty;
    $html->template_dir = PUBPH . 'views/modules/';
    $html->compile_dir = VNDPH . 'smarty/demo/templates_c/';
    $html->config_dir = VNDPH . 'smarty/demo/configs/';
    $html->cache_dir = VNDPH . 'smarty/demo/cache/';
