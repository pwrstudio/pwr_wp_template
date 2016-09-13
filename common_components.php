<?php // Basic loop ?>
<?php $args = array('post_type' => 'post', 'category_name' => "artists", 'posts_per_page' => -1); ?>
<?php $about = new WP_Query( $args ); ?>
<?php while ( $about->have_posts() ) : $about->the_post(); ?>
  <p><?php echo get_the_title();?></p>
<?php endwhile; ?>
<?php wp_reset_query(); ?>


<?php // Get page by name ?>
<?php $page = get_page_by_title( 'name' );?>
<?php $text = get_field('text', $page->ID);?>


<?php // ACF image loop ?>
<?php if(have_rows('media')):?>
  <?php while ( have_rows('media') ) : the_row(); ?>
    <?php $image = get_sub_field('image'); ?>
    <img src="<?php echo $image['sizes']['pwr-large']; ?>">
    <figcaption><?php echo the_sub_field('caption'); ?></figcaption>
  <?php endwhile; ?>
<?php endif; ?>


<?php // Include gallery partial ?>
<?php get_template_part('gallery'); ?>


<?php // Swiper HTML structure ?>
<div class="swiper-container">
  <div class="swiper-wrapper">
    <div class="swiper-slide">PWR template</div>
  </div>
</div>


<?php // Get the_content on single page ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
<?php endwhile; endif;?>