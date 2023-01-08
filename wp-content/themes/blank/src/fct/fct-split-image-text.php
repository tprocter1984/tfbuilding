<?php


// Split - Text / Image
// ==================================================================
if (get_row_layout() == 'fct_split_image_text'): ?>

    <section class="fct_section fct_split_image_text">
        <div class="container">
            <?php

            $image = get_sub_field('fct_split_image_text_left');
            $spacer = "https://place-hold.it/600x500";

            if ($image) {
                $image_url = $image['sizes']['large'];
            } else {
                $image_url = $spacer;
            }

            ?>

            <div class="left" style="background-image:url('<?php echo $image_url; ?>');">
                <div class="overlay"></div>
                <img src="<?php echo $spacer; ?>"/>
            </div>

            <div class="right">
                <?php the_sub_field('fct_split_image_text_right'); ?>
            </div>
        </div>
    </section>

<?php endif; ?>
