<?php


// Split - Text / Image
// ==================================================================
if (get_row_layout() == 'fct_split_text_image'): ?>

    <section class="fct_section fct_split_text_image">
        <div class="container">
            <div class="left">
                <?php the_sub_field('fct_split_text_image_left'); ?>
            </div>

            <?php

            $image = get_sub_field('fct_split_text_image_right');
            $spacer = "https://place-hold.it/200x300";

            if ($image) {
                $image_url = $image['sizes']['large'];
            } else {
                $image_url = $spacer;
            }

            ?>

            <div class="right" style="background-image:url('<?php echo $image_url; ?>');">
                <div class="overlay"></div>
                <img src="<?php echo $spacer; ?>"/>
            </div>
        </div>
    </section>

<?php endif; ?>
