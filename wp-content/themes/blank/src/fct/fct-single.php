<?php

global $post;
$content_fields = get_fields();

// check if the flexible content field has rows of data
if (have_rows('fct_content_block')):
    while (have_rows('fct_content_block')) : the_row();

        require('fct-banner.php');
        require('fct-full-image.php');
        require('fct-full-call-to-action.php');
        require('fct-full-image-with-lists.php');
        require('fct-full-text.php');
        require('fct-full-text-large.php');
        require('fct-full-work-examples.php');
        require('fct-page-links-with-text.php');
        require('fct-split-image-text.php');
        require('fct-split-text-image.php');
        require('fct-split-text-text.php');
        require('fct-gallery.php');

    endwhile;

else:
    ?>

    <section class="non_fct_section">
        <div class="container">
            <?php echo the_content(); ?>
        </div>
    </section>

    //

<?php
endif;
