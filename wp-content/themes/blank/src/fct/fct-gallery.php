<?php

// 5. Split - Text / Text
// ==================================================================
if (get_row_layout() == 'fct_gallery'): ?>

    <section class="fct_section fct_gallery">

        <?php
        $images = get_sub_field('gallery');
        if ($images): ?>
            <div class="images">
                <?php foreach ($images as $image): ?>
                    <a class="image" href="<?php echo $image['sizes']['large']; ?>">
                        <div class="overlay"></div>
                        <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>"/>

                        <?php //echo $image['caption']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </section>

<?php endif; ?>