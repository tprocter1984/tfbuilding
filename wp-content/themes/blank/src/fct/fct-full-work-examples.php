<?php
global $base;

// 5. Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_work_examples'): ?>
    <?php if (have_rows('fct_work_posts')): ?>
        <section class="fct_section fct_work_examples">
            <h2 class="main-heading">Case Studies</h2>

            <div class="examples">

                <?php while (have_rows('fct_work_posts')): the_row(); ?>
                    <?php

                    $work = get_sub_field('fct_work_post');
                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($work->ID), 'large');

                    ?>

                    <a href="<?php echo get_the_permalink($work->ID); ?>" class="work-item">

                        <div class="work-image" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
                            <div class="overlay-black"></div>
                            <div class="overlay"></div>
                            <img src="<?php echo $base; ?>/images/spacer.png"/>
                        </div>

                        <div class="work-title">
                            <img src="<?php echo $base; ?>/images/spacer.png"/>

                            <div class="text">
                                <h3><?php echo $work->post_title; ?></h3>
                                <button>more <i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>

                    </a>

                <?php endwhile; ?>

            </div>
        </section>
    <?php endif; ?>

<?php endif; ?>