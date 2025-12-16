<!DOCTYPE html>
<html lang="cs">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if( is_home() ) { ?>
            <title>PrimaKavárna</title>
        <?php } else {   ?>
            <title><?php wp_title( '', true, 'right'); ?></title>
        <?php } ?>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/all.min.css">

    <?php wp_head(); ?>

</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JKB7T6EKQE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JKB7T6EKQE');
</script>

<body>