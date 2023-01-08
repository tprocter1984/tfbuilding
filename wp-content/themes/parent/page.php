<?php get_header(); ?>

<div class="grid-container">
    <div class="content-100">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                ?>

                <h1><?php the_title(); ?></h1>
                <div class="content"><?php the_content(); ?></div>

                <?php
            } // end while
        } // end if
        ?>
    </div>
</div>

<?php get_footer(); ?>