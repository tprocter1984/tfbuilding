<?php

// Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_full_call_to_action'): ?>

    <section class="fct_section fct_full_call_to_action">

        <?php $buttons = get_sub_field('fct_full_call_to_action_buttons'); ?>
        <h3 class="field">
            <?php if(the_sub_field('fct_full_call_to_action_main_heading')): ?>
            <span class="small-text"><?php the_sub_field('fct_full_call_to_action_main_heading'); ?></span>
            <?php endif; ?>
            <?php if(the_sub_field('fct_full_call_to_action_small_heading')): ?>
            <span class="field large-text"><?php the_sub_field('fct_full_call_to_action_small_heading'); ?></span>
            <?php endif; ?>
        </h3>

        <div class="buttons">
            <?php foreach ($buttons as $button): ?>
                <a href="<?php echo $button['fct_full_call_to_action_buttons_destination']; ?>"
                    class="button orange">
                    <?php echo $button['fct_full_call_to_action_buttons_text']; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="background-image"></div>

    </section>

<?php endif; ?>

