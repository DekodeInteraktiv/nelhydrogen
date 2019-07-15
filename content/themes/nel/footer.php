</div><!-- #main -->

<footer id="footer" class="bg-secondary pad-top-equal">

    <div class="footer-menus container">

        <div class="row">

            <div class="columns small-12 medium-6 large-3">
                <h5><?php _e( 'Nel Hydrogen', 'nel' ); ?></h5>
                <ul class="footer-menu">
					<?php
					$phone_number = get_field( 'main_phone', 'options' );
					?>
                    <li><a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></a></li>
                    <li><?php echo do_shortcode( '[email]' . get_field( 'main_email', 'options' ) . '[/email]' ); ?></li>
                </ul>
            </div>

            <div class="columns small-12 medium-6 large-3">
				<?php
				$locations = get_nav_menu_locations();
				if ( isset( $locations['footer-nav-primary'] ) ) {
					$nav_menu_object = wp_get_nav_menu_object( $locations['footer-nav-primary'] );
					echo '<h5>' . $nav_menu_object->name . '</h5>';
					wp_nav_menu( array(
						'container'       => 'nav',
						'container_class' => 'footer-menu',
						'menu'            => '',
						'menu_class'      => '',
						'theme_location'  => 'footer-nav-primary',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'depth'           => 1,
						'fallback_cb'     => false,
					) );
				}
				?>
            </div>

            <div class="columns small-12 medium-6 large-3">
                <h5><?php _e( 'Menu', 'nel' ); ?></h5>
				<?php hey_footer_menu(); ?>
            </div>

            <div class="columns small-12 medium-6 large-3">
                <h5><?php _e( 'Connect', 'nel' ); ?></h5>
				<?php

				/**
				 * Get nav menu
				 */
				ob_start();
				wp_nav_menu( array(
					'container'       => 'nav',
					'container_class' => 'footer-menu',
					'menu'            => '',
					'menu_class'      => '',
					'theme_location'  => 'social',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'depth'           => 1,
					'fallback_cb'     => false,
				) );
				$social_menu = ob_get_contents();
				ob_end_clean();

				if ( ! $social_menu ) {
					?>
                    <ul class="footer-menu">
                        <li><a title="<?php _e( 'Go to Twitter', 'nel' ); ?>" target="_blank" rel="noopener noreferrer"
                               href="https://twitter.com/nelhydrogen"><?php _e( 'Twitter', 'nel' ); ?></a></li>
                        <li><a title="<?php _e( 'Go to LinkedIn', 'nel' ); ?>" target="_blank" rel="noopener noreferrer"
                               href="https://www.linkedin.com/company/nel-hydrogen"><?php _e( 'LinkedIn', 'nel' ); ?></a>
                        </li>
                    </ul>
					<?php
				} else {
					echo $social_menu;
				}

				?>
            </div>

        </div>

    </div>

    <div class="footer-credits container container--wide clearfix">

        <div class="columns small">
            <p class="medium-float-left footer-credits__year">© NEL <?php echo date( 'Y' ); ?></p>
            <ul class="medium-float-left footer-credits__nav">
				<?php

				// Cookie page link
				$cookie_page = get_field( 'page_for_cookies', 'options' );
				if ( $cookie_page ) {
					echo '<li><a title="' . esc_attr( $cookie_page->post_title ) . '" href="' . get_permalink( $cookie_page->ID ) . '">' . $cookie_page->post_title . '</a></li>';
				}

				// Privacy policy page link
				$policy_page_id = get_option( 'wp_page_for_privacy_policy' );
				if ( ! empty( $policy_page_id ) && get_post_status( $policy_page_id ) === 'publish' ) {
					echo '<li><a title="' . esc_attr( get_the_title( $policy_page_id ) ) . '" href="' . get_permalink( $policy_page_id ) . '">' . get_the_title( $policy_page_id ) . '</a></li>';
				}

				?></ul>
            <p class="medium-text-right medium-float-right">
				<?php
				$heydays_link = '<a href="http://heydays.no" rel="noreferrer noopener" target="_blank">Heydays</a>';
				echo sprintf( __( 'Design & code by %s', 'nel' ), $heydays_link );
				?>
            </p>
        </div>

    </div>

</footer>

<div class="menu-overlay"></div>

<?php
if ( ! is_page_template( 'page-templates/contact.php' ) ) {
	get_template_part( 'partials/form', 'contact' );
}
?>

</div><!-- #page -->

<div id="searchmodal" class="mfp-hide">
    <div class="container">
        <div class="row column">
			<?php get_search_form(); ?>
        </div>
    </div>
</div>

<a href="#" class="btn-top" title="<?php _e( 'Back to top', 'nel' ); ?>"><span class="icon-arrow-up"></span></a>

<?php
get_template_part( 'partials/tmpl-cision', 'article' );
get_template_part( 'partials/tmpl-cision', 'item' );
?>

<?php
/**
 * Scrape for Cision posts
 */
$exclude_ids = nel_get_meta_values( 'cision_id', 'cision_post' );
if ( ! $exclude_ids ) {
	$exclude_ids = array();
}
echo '<div id="js-cision-scraper" data-exclude="' . implode( ',', $exclude_ids ) . '"></div>';
?>

<?php wp_footer(); ?>

</body>
</html>