<?php if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<?php get_header(); ?>

<section class="content" role="main">

    <h1 class="main-heading">
        <?php the_title(); ?>
    </h1>

    <?php include('src/fct/fct-single.php'); ?>

    <?php //the_content(); ?>

</section>
<!-- #content -->

<?php get_footer(); ?>
