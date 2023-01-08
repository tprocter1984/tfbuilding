<?php get_header(); ?>

<div class="content-area">
    
    <div class="grid-container">
  
        <div class="grid-100">
            
            <section id="work">
            
            <div class="title">
                <h3>Recent Work</h3>
            </div>
                
            <?php

            $args = array(
                'posts_per_page' => '-1',
                'category_name=recent-work'
            );
            $the_query = new WP_Query( $args );         
            while ( $the_query->have_posts() ) : $the_query->the_post(); 

            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
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

            <?php endwhile; wp_reset_postdata(); ?>

            </section>    

        </div>             

    </div>
    
</div>
  
<?php get_footer(); ?>
