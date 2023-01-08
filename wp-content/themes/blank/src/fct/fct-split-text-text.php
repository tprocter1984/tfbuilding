<?php

// Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_split_text_text'): ?>

    <section class="fct_section fct_split_text_text">
        <div class="container">
            <div class="left">
                <?php the_sub_field('fct_split_text_text_left'); ?>
            </div>
            <div class="right">
                <?php the_sub_field('fct_split_text_text_right'); ?>
            </div>
        </div>
    </section>

<?php endif; ?>
