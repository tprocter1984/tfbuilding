<?php 


get_header(); ?>

<?php //get_template_part('content','banner'); ?>

<div class="content-area">
    <div class="grid-container">
        <div class="grid-100">
            
            <section id="banner-container">
                <div class="grid-35 banner-text-left">
                    <div class="padding">
                        <h1><?php echo get_field('banner_title',2613); ?></h1>
                        <p><?php echo get_field('banner_text',2613); ?></p>
                        <div class="button">
                            <button>more »</button>
                        </div>
                    </div>
                </div>
                <div class="grid-65 " id="banner" style="background-image:url('<?php echo get_field('banner_image',2613); ?>')">
                    <div class="overlay"></div>
                    <div class="overlay-tflogo"></div>
                    <img class="banner-spacer" src="<?php echo $base; ?>/_/images/banner-spacer.png" />
                </div>
            </section>
 
            <section id="quote-bar">
                <div class="quote-call-to-action">
                    <div class="padding">
                        <?php wp_nav_menu(array('menu' => 'Quick Quote')); ?>
                    </div>
                </div>
                <div class="quote-information">
                    <div class="padding">
                        <p>To help you with your project, we can give you a quick quote on the work that you require. Just follow the link
                            and fill in the short form and we'll get back to you as quickly as possible.</p>
                    </div>
                </div>
            </section>

            <section id="work">
                <div class="title">
                    <h3>OUR LATEST WORK</h3>
                </div>
                <?php
                $args = array(
                    'posts_per_page' => '6',
                    'category_name=recent-work'
                );
                $the_query = new WP_Query($args);
                while ($the_query->have_posts()) : $the_query->the_post();

                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    ?>

                    <a href="<?php the_permalink(); ?>" class="work-piece">

                        <div class="work-image" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
                            <div class="overlay-black"></div>
                            <div class="overlay"></div>
                            <img src="<?php echo $base; ?>/_/images/spacer.png" />       
                        </div>                    

                        <div class="work-title">
                            <img src="<?php echo $base; ?>/_/images/spacer.png" />
                            <div class="text">
                                <h2><?php the_title(); ?></h2>
                                <button>more »</button>
                            </div>   
                        </div>

                    </a>

                <?php endwhile;
                wp_reset_postdata(); ?>
            </section>    
        </div>             
    </div>
</div>

<?php get_footer(); ?>
