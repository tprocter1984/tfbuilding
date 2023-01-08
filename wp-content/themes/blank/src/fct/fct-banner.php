<?php
// Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_banner'): ?>

    <?php if (get_sub_field('fct_banner_image')): ?>
        <style>
            <?php $image = get_sub_field('fct_banner_image'); ?>
            .fct_banner {
                background-image : url('<?php echo $image['url'] ?>');
            }
        </style>
        <section class="fct_section fct_banner"></section>
    <?php else: ?>
        <style>
            .fct_banner {
                background-image : url('<?php the_sub_field('fct_banner_image_url'); ?>');
            }
        </style>
        <section class="fct_section fct_banner"></section>
    <?php endif; ?>

<?php endif; ?>
