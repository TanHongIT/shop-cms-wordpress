<!DOCTYPE html>
<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if !IE]> <html <?php language_attributes(); ?>> <![endif]-->

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <link rel="profile" href="http://gmgp.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <!--hook này để giúp WordPress hiểu được đây là khu vực thẻ <head>-->
    <?php wp_head(); ?>

</head>

<!--Thêm class tượng trưng cho mỗi trang lên <body> để tùy biến-->
<body <?php body_class(); ?>>

    <div id="container">
        <header id="header">
            <?php tnt_logo(); ?>
            <?php tnt_menu('main-menu'); ?>
        </header>