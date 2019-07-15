<?php

$header_panels = get_field( 'header_panel' );

if ( $header_panels ) {

	$header_panel = $header_panels[0];

} else {

	/**
	 * Front page hero fallback
	 */
	$header_panel  = array(
		'title'           => 'Unlocking the potential of renewables',
		'content'         => '',
		'background_type' => 'spacetravel',
		'button'          => false
	);
	$hydrogen_page = get_page_by_template( 'page-templates/hydrogen.php' );
	if ( $hydrogen_page ) {
		$hydrogen_page_url      = get_permalink( $hydrogen_page->ID );
		$header_panel['button'] = array(
			'link' => array(
				'title' => 'Discover how',
				'url'   => $hydrogen_page_url
			)
		);
	}
}
?>
<header class="Hero">
    <div class="Hero__background bg-black">
		<?php
		if ( $header_panel['background_type'] == 'spacetravel' ) {
			echo '<div class="galaxy-home galaxy"></div>';
		} elseif ( $header_panel['background_type'] == 'image' ) {
			if ( $header_panel['background_image'] ) {
				$bgset = hey_get_attachment_image_bgset( $header_panel['background_image']['id'], 'full' );
				echo '<div class="Hero__background-image bg-image lazyload" ' . $bgset . '></div>';
			}
		}
		?>
    </div>
    <div class="Hero__container">
        <div class="Hero__content row align-center">
            <div class="column small-12 large-10 xlarge-8">
                <h1 class="Hero__title"><?php echo $header_panel['title']; ?></h1>
				<?php
				if ( $header_panel['content'] ) {
					echo '<p class="Hero__body lead">' . $header_panel['content'] . '</p>';
				}
				?>
				<?php
				if ( $header_panel['button'] ) {
					$button_link = $header_panel['button']['link'];
					if ( isset( $button_link['url'] ) && isset( $button_link['title'] ) ) {
						echo '<a href="' . $button_link['url'] . '" class="Hero__button btn btn-a">' . $button_link['title'] . '</a>';
					}
				}
				?>
            </div>
        </div>
    </div>
	<?php if ( get_field( 'enable_scroll_button' ) ) : ?>
        <div class="Hero__footer">
            <div class="row align-center">
                <div class="column">
					<?php echo do_shortcode( '[scroll_button]' ); ?>
                </div>
            </div>
        </div>
	<?php endif; ?>
</header>