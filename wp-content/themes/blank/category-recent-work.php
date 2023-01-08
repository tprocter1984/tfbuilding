<?php
global $base;
get_header(); ?>

    <h1 class="main-heading"><?php single_cat_title(); ?></h1>

    <section id="work">

        <?php
        /*
        $args = array(
            'posts_per_page' => '2',
            'category_name=recent-work'
        );
        $the_query = new WP_Query( $args );
        */

        while (have_posts()) : the_post();

            $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            ?>

            <a href="<?php the_permalink(); ?>" class="work-item">

                <div class="work-image" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
                    <div class="overlay-black"></div>
                    <div class="overlay"></div>
                    <img src="<?php echo $base; ?>/images/spacer.png"/>
                </div>

                <div class="work-title">
                    <img src="<?php echo $base; ?>/images/spacer.png"/>

                    <div class="text">
                        <h2><?php the_title(); ?></h2>
                        <button>more <i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>

            </a>

        <?php endwhile;
        wp_reset_postdata(); ?>
    </section>

    <section>
        <div class="introduction">
            <div class="navigation"><p><?php posts_nav_link(); ?></p></div>
        </div>
    </section>

<?php get_footer(); ?>