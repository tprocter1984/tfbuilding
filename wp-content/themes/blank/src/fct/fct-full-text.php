<?php

// 5. Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_full_text'): ?>

    <section class="fct_section fct_full_text">
            <?php the_sub_field('text'); ?>
    </section>

<?php endif; ?>