<?php if( have_rows('media') ): ?>

  <nav class="arrow left"></nav>
  <nav class="arrow right"></nav>

  <section class="image-list-container">
    <?php while ( have_rows('media') ) : the_row(); ?>
      <?php if(get_sub_field('type') == 'Image'):?>
        <?php $image = get_sub_field('image'); ?>
        <div class='image'>
          <img src="<?php echo $image['sizes']['pwr-large']; ?>">
          <figcaption><?php echo the_sub_field('caption'); ?></figcaption>
        </div>
      <?php elseif(get_sub_field('type') == 'Video'): ?>
        <div class='video'> 
          <?php echo the_sub_field('video');?>
          <figcaption><?php echo the_sub_field('caption'); ?></figcaption>
        </div>
      <?php endif; ?>
    <?php endwhile; ?>
  </section>

<?php endif; ?>

