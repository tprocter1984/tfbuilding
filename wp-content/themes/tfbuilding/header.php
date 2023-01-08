<?php
global $images;
global $base;
$images = array(
    'roofing.jpg',
    'patios.jpg',
    'painting.jpg',
    'building.jpg'
);
?>

<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
        <meta name="google-site-verification" content="b4Hzc2iuMX5eamLiJuEtBBzSl0WAJ7AttZt1nGwcJik" />
    </head>
    <body <?php body_class(); ?>>

        <?php /*
        <div id="topbar">
            <div class="grid-container">
                <div class="grid-100">
                    <a class="logo" href="<?php echo bloginfo('url'); ?>"></a>
                    <nav class="mobile-menu">                
                        <li class="mobile-icon"><a href="#"><img src="<?php echo $base; ?>/_/images/menu-icon.png" /></a></li>
                        <?php wp_nav_menu(array('menu' => 'Main Menu')); ?>    
                    </nav>    
                    <div class="phone-number">
                        <p>Call on: 07985711011</p>
                    </div>    
                </div>        
            </div>    
        </div>
        <?php */ ?>

        <div class="grid-container">
            <div class="grid-100">
                <div class="padding">
                    <a class="logo" href="<?php echo bloginfo('url'); ?>"></a>
                    <nav>
                        <?php wp_nav_menu(array('menu' => 'Main Menu')); ?>
                    </nav>
                    <div class="phone-number">
                        <p>Call on: 07985711011</p>
                    </div>
                </div>
            </div>
        </div>
