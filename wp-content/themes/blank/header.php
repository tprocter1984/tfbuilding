<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="3869540A1657667AA5A11A63293D889D"/>
    <title><?php wp_title(''); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->
    <?php wp_head(); ?>
	<meta name="p:domain_verify" content="d8439ce07d2454451098144e3a7c6c41"/>

</head>

<body <?php body_class(); ?>>

<div id="wrapper">
<header>
    <div class="container">
        <div class="meta" itemscope itemtype="http://schema.org/Organization">
            <div class="logo">
                <a href="/"><img width="46" height="57" src="<?php echo get_template_directory_uri(); ?>/images/logo-circle.png" alt="TF
                Buidling"/></a>
            </div>
            <div class="info">
                <address class="address">
                    <div vocab="http://schema.org/" typeof="LocalBusiness">
                        <?php if (is_front_page()): ?>
                            <h1><span property="name"><a href="/">TF Building & Renovations</a></span></h1>
                        <?php else: ?>
                            <h3><span property="name"><a href="/">TF Building & Renovations</a></span></h3>
                        <?php endif; ?>
                        <span property="description">Property Renovation, Handmade Kitchens &amp; Bespoke Joinery</span>
                    </div>
                </address>
                <?php /*
                <span class="email"><a href="/contact/">tom@tfbuilding.co.uk</a></span>
                <span class="telephone"><a itemprop="telephone" href="tel:+08449670565">+44 (0)1756 798751</a></span>

                <div class="social">
                    <ul>
                        <li><a href="https://twitter.com/" itemprop="sameAs" class="twitter">twitter</a></li>
                        <li><a href="https://uk.linkedin.com/company/" itemprop="sameAs" class="linkedin">linkedin</a>
                        </li>
                        <li><a href="https://www.facebook.com/" itemprop="sameAs" class="facebook">facebook</a></li>
                        <li><a href="https://plus.google.com/+tfbuilding/posts" itemprop="sameAs" class="google">google
                                plus</a></li>
                    </ul>
                </div>
                */
                ?>

            </div>
        </div>

        <?php wp_nav_menu(array('theme_location' => 'primary_nav', 'menu_class' => 'main-menu')); ?>
    </div>
</header>








