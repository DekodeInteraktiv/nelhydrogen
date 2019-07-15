<?php
$drawer_menus = get_drawer_menus();
if ( $drawer_menus ) {
	?>
    <div data-scope="DrawerNav" class="DrawerNav">
        <div class="DrawerNav__content">
			<?php
			foreach ( $drawer_menus as $key => $drawer_menu_items ) {
				echo '<div id="DrawerNav-' . $key . '" class="DrawerNav__submenu bg-secondary">';
				echo '<nav class="row DrawerNav__inner small-up-1 medium-up-' . count( $drawer_menu_items ) . ' medium-text-center">';
				foreach ( $drawer_menu_items as $menu_item ) {
					?>
                    <a class="columns DrawerNav__item" href="<?php echo $menu_item->url; ?>">
                        <div class="DrawerNav__image">
							<?php
							$image_id = get_field( 'featured_image', $menu_item->ID );
							if ( $image_id ) {
								echo wp_get_attachment_image( $image_id, 'large' );
							}
							?>
                        </div>
                        <div class="DrawerNav__text">
                            <h3 class="DrawerNav__title"><?php echo $menu_item->title; ?></h3>
							<?php
							if ( $menu_item->post_content ) {
								echo '<p class="DrawerNav__excerpt">' . $menu_item->post_content . '</p>';
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
        </div>
    </div>
	<?php
}
?>