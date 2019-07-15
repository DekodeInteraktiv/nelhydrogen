<?php
$homepage_menu_items = get_nav_menu_items_by_location( 'homepage-menu' );
if ( $homepage_menu_items ) {
	echo '<div class="HomepageNav">';
	echo '<nav class="row HomepageNav__inner small-up-1 medium-up-' . count( $homepage_menu_items ) . ' medium-text-center">';
	foreach ( $homepage_menu_items as $menu_item ) {
		?>
        <a class="columns HomepageNav__item" href="<?php echo $menu_item->url; ?>">
            <div class="HomepageNav__image">
				<?php
				$image_id = get_field( 'featured_image', $menu_item->ID );
				if ( $image_id ) {
					echo wp_get_attachment_image( $image_id, 'large' );
				}
				?>
            </div>
            <div class="HomepageNav__text">
                <h3 class="HomepageNav__title"><?php echo $menu_item->title; ?></h3>
				<?php
				if ( $menu_item->post_content ) {
					echo '<p class="HomepageNav__excerpt">' . $menu_item->post_content . '</p>';
				}
				?>
            </div>
        </a>
		<?php
	}
	echo '</nav>';
	echo '</div>';
}
?>