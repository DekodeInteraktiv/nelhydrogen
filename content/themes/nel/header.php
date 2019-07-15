<?php
/**
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" href="<?php echo site_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="<?php echo site_url(); ?>/apple-touch-icon-precomposed.png">

    <meta name="msapplication-square70x70logo" content="<?php echo site_url(); ?>/tile.png">
    <meta name="msapplication-square150x150logo" content="<?php echo site_url(); ?>/tile.png">
    <meta name="msapplication-square310x310logo" content="<?php echo site_url(); ?>/tile.png">
    <meta name="msapplication-wide310x150logo" content="<?php echo site_url(); ?>/tile-wide.png">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'partials/drawer-nav' ); ?>

<div id="page">

    <header id="header" class="container container--wide pad-top-equal">
        <div class="row expanded">
            <div class="columns">
				<?php hey_main_menu(); ?>
            </div>
        </div>
    </header>

    <div id="main">