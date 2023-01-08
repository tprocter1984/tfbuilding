<?php

// Split - Image
// ==================================================================
if (get_row_layout() == 'fct_full_image'): ?>

    <section class="fct_section fct_full_image">
        <?php $image = get_sub_field('fct_full_image_image'); ?>
        <img src="<?php echo $image['url']; ?>" />
    </section>

<?php endif; ?>