<?php
global $post;

get_header();
$bannerUrl = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'work-banner');
$bannerUrl = $bannerUrl[0];

$introUrl = get_field('intro_image');
$contentImageUrl = get_field('content_image');

if (!$bannerUrl) {
    $bannerUrl = "https://placehold.it/1200x400";
}

if (!$introUrl) {
    $introUrl = "https://placehold.it/800x800";
} else {
    $introUrl = $introUrl['sizes']['large'];
}

if (!$contentImageUrl) {
    $contentImageUrl = "https://placehold.it/800x800";
} else {
    $contentImageUrl = $contentImageUrl['sizes']['large'];
}

?>
    <div class="grid-container">
        <section id="single-work">

            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    ?>
                    <!-- <div class="feature-image"><img src="<?php //echo $bannerUrl; ?>"/></div> -->

                    <div class="table">
                        <div class="l-cell text intro">
                            <h1><?php the_title(); ?></h1>

                            <h2><?php the_field('sub_heading'); ?></h2>
                        </div>
                        <div class="r-cell text">
                            <?php the_content(); ?>
                        </div>
                    </div>

                <?php
                } // end while
            } // end if
            ?>

        </section>

        <section id="quote-bar">
            <div class="quote-call-to-action">
                <div class="padding">
                    <?php wp_nav_menu(array('menu' => 'Quick Quote')); ?>
                </div>
            </div>
            <div class="quote-information">
                <div class="padding">
                    <p>To help you with your project, we can give you a quick quote on the work that you require. Just
                        follow the link
                        and fill in the short form and we'll get back to you as quickly as possible.</p>
                </div>
            </div>
        </section>
    </div>
<?php get_footer(); ?>
