<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  
<head>
  
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="theme-color" content="#000">
  
  <?php // FAVICONS ?>
  <?php get_template_part('template_parts/favicons'); ?>

  <?php // META INFO ?>
  <?php get_template_part('template_parts/meta_info'); ?>


  <title><?php wp_title(" | ", TRUE, "RIGHT"); ?></title>

  <?php wp_head(); ?>
    
</head>

<body>

