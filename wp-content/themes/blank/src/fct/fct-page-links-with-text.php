<?php

// Page Links w/ Text
// ==================================================================
if (get_row_layout() == 'fct_page_links_with_text'): ?>

    <section class="fct_section fct_page_links_with_text">

        <?php if (have_rows('fct_page_links_with_text_links')): ?>
            <div class="pods">
                <?php while (have_rows('fct_page_links_with_text_links')): the_row(); ?>
                    <div class="pod">

                        <?php
                        $image = get_sub_field('fct_page_links_with_text_links_image');
                        $placeholder = "https://place-hold.it/600x400";

                        if ($image) {
                            //$image_url = $image['url'];
			    $image_url = $image['sizes']['medium'];
                        } else {
                            $image_url = $placeholder;
                        }
                        ?>
                        <a href="<?php the_sub_field('fct_page_links_with_text_links_link'); ?>">

                            <div class="image" style="background-image:url('<?php echo $image_url; ?>');">
                                <div class="overlay-black"></div>
                                <div class="overlay"></div>
                                <img src="<?php echo $placeholder; ?>"/>
                            </div>

                        </a>

                        <div class="supporting-text">

                            <h2 class="heading"><a
                                    href="<?php the_sub_field('fct_page_links_with_text_links_link'); ?>"><?php the_sub_field('fct_page_links_with_text_links_heading'); ?></a>
                            </h2>

                            <p><?php the_sub_field('fct_page_links_with_text_links_text'); ?></p>

                            <?php if (get_sub_field('fct_page_links_with_text_links_link')): ?>
                                <a class="readmore button orange"
                                   href="<?php the_sub_field('fct_page_links_with_text_links_link'); ?>">
                                    <?php the_sub_field('fct_page_links_with_text_links_button'); ?>
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>

                        </div>


                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;; ?>

    </section>

<?php endif; ?>


