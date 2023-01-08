<?php
global $base;
get_header(); ?>

    <section id="work">

        <div class="title">
            <h3>Recent Work</h3>
        </div>

        <?php

        $args = array(
            'posts_per_page' => '6',
            'category_name' => 'blog',
            'cat' => '-1'
        );
        $the_query = new WP_Query($args);
        while ($the_query->have_posts()) : $the_query->the_post();

            $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            ?>

            <a href="<?php the_permalink(); ?>" class="work-item">

                <div class="work-image" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
                    <div class="overlay-black"></div>
                    <div class="overlay"></div>
                    <img src="<?php echo $base; ?>/images/spacer.png" />
                </div>

                <div class="work-title">
                    <img src="<?php echo $base; ?>/images/spacer.png" />

                    <div class="text">
                        <h2><?php the_title(); ?></h2>
                        <button>more »</button>
                    </div>
                </div>

            </a>

        <?php endwhile;
        wp_reset_postdata(); ?>
        <div class="navigation"><p><?php posts_nav_link(); ?></p></div>

    </section>

<?php get_footer(); ?>