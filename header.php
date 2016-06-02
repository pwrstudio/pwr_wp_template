<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  
<head>
  
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="theme-color" content="#000">

  <?php $tempdir = get_template_directory_uri();?>
  
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $tempdir;?>/img/favicons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $tempdir;?>/img/favicons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $tempdir;?>/img/favicons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $tempdir;?>/img/favicons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $tempdir;?>/img/favicons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $tempdir;?>/img/favicons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $tempdir;?>/img/favicons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $tempdir;?>/img/favicons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $tempdir;?>/img/favicons/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $tempdir;?>/img/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $tempdir;?>/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $tempdir;?>/img/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $tempdir;?>/img/favicons/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $tempdir;?>/img/favicons/manifest.json">
  <meta name="msapplication-TileColor" content="#bebebe">
  <meta name="msapplication-TileImage" content="<?php echo $tempdir;?>/img/favicons/ms-icon-144x144.png">

  <title><?php wp_title(" | ", TRUE, "RIGHT"); ?></title>

  <?php wp_head(); ?>
    
</head>

<body>

