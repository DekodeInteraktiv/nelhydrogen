<?php
/**
 * Register Menus
 *
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */

register_nav_menus( array(
	'primary-menu'       => __( 'Primary menu', 'nel-admin' ),
	'secondary-menu'     => __( 'Secondary menu', 'nel-admin' ),
	'homepage-menu'      => __( 'Homepage menu', 'nel-admin' ),
	'footer-nav-primary' => __( 'Primary footer menu', 'nel-admin' ),
	'social'             => __( 'Social media', 'nel-admin' )
) );

/**
 * Main menu
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'hey_main_menu' ) ) {
	function hey_main_menu() {

		$menu_items_before = '<li class="item-logo"><a title="Nel" class="logo" href="' . home_url( '/' ) . '">' . hey_get_inline_svg( '/images/logo.svg' ) . '</a></li>';

		// add search field to menu
		$menu_items_after = '';

		$language_switch = get_language_switcher();
		if ( $language_switch ) {
			$menu_items_after .= $language_switch;
		}

		$is_search        = ( is_search() ) ? ' current-menu-item' : '';
		$menu_items_after .= '<li class="item-search show-for-large' . $is_search . '"><a class="open-popup-link-search" data-mfp-src="#searchmodal" title="' . __( 'Search', 'nel' ) . '" href="' . home_url( '?s=' ) . '"><span class="icon-search"></span></a></li>
		<li class="item-search-mobile hide-for-large">
			<form method="GET" action="' . home_url( '/' ) . '">
				<input type="search" placeholder="' . __( 'Search', 'nel' ) . '" name="s">
			</form>
		</li>';


		wp_nav_menu( array(
			'container'       => 'nav',
			'container_class' => 'main-menu',
			'menu'            => '',
			'menu_class'      => 'primary-menu',
			'theme_location'  => 'primary-menu',
			'before'          => '',                                 // Before each link <a>
			'after'           => '',                                  // After each link </a>
			'link_before'     => '',                            // Before each link text
			'link_after'      => '',                             // After each link text
			'depth'           => 2,                                   // Limit the depth of the nav
			//'fallback_cb' => false,                       // Fallback function (see below)
			'items_wrap'      => '<ul id="%1$s" class="%2$s">' . $menu_items_before . '%3$s' . $menu_items_after . '</ul>',

		) );

		?>
        <a title="Nel" class="logo logo-mobile"
           href="<?php echo home_url( '/' ); ?>"><?php echo hey_get_inline_svg( '/images/logo.svg' ); ?></a>
        <button aria-label="<?php _e( 'Toggle menu', 'nel' ); ?>" class="mobile-menu-toggle" data-menu=".main-menu"
                data-overlay=".menu-overlay">
			<span class="burger">
				<span class="b-top"></span>
				<span class="b-center"></span>
				<span class="b-bottom"></span>
			</span>
        </button>
		<?php

	}

	function hey_footer_menu() {

		$product_page_id = "100";

		wp_nav_menu( array(
			'container'       => 'nav',
			'container_class' => 'footer-menu',
			'menu'            => '',
			'menu_class'      => 'secondary-menu',
			'theme_location'  => 'secondary-menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 1,
			'fallback_cb'     => false,
		) );

	}

}


/*
Dynamically add pagebuilder items to main menu structure
*/


function add_pagebuilder_nav_menu_items( $items, $menu, $args ) {

	if ( is_admin() ) {
		return $items;
	}

	// Only update the main menu
	$locations = get_nav_menu_locations();

	// Return if primary menu is not defined
	if ( ! isset( $locations['primary-menu'] ) ) {
		return $items;
	}

	// Make sure we are only applying this to the main menu
	if ( $menu->term_id != $locations['primary-menu'] ) {
		return $items;
	}

	$new_order = array();

	foreach ( $items as $key => $item ) {

		$insert_after = get_field( 'insert_after_section', $item->ID );
		if ( $insert_after ) {
			// write_log('Insert after is called');
			// write_log($item->title);
			continue;
		} else {
			$new_order[] = $item;
		}

		if ( $item->object == 'page' ) {

			$blocks = get_field( 'blocks', $item->object_id );

			if ( $blocks ) {

				foreach ( $blocks as $block ) {

					if ( ! isset( $block['enable_navigation'] ) || ! isset( $block['title'] ) ) {
						continue;
					}

					if ( isset( $block['status'] ) ) {
						if ( $block['status'] == 'hidden' ) {
							continue;
						} elseif ( $block['status'] == 'private' && ! current_user_can( 'edit_posts' ) ) {
							continue;
						}
					}

					if ( $block['enable_navigation'] && $block['title'] ) {

						$new_item             = new stdClass();
						$new_item->object     = 'custom';
						$new_item->type       = 'custom';
						$new_item->title      = $block['title'];
						$new_item->post_title = $block['title'];
						$new_item->url        = '#' . sanitize_title( $block['title'] );
						$new_item->target     = '';
						$new_item->object_id  = '';
						$new_item->classes    = array();
						$new_item->menu_order = 0;

						$new_item->type_label   = 'Pagebuilder item';
						$new_item->description  = 'Auto added pagebuilder item';
						$new_item->post_excerpt = '';
						$new_item->xfn          = '';

						$new_item->db_id = '';
						$new_item->ID    = '';

						$new_item->menu_item_parent = $item->ID;

						$new_order[] = $new_item;

						foreach ( $items as $c_key => $c_item ) {
							if ( $c_item->menu_item_parent == $item->ID ) {
								$insert_after = get_field( 'insert_after_section', $c_item->ID );
								if ( strtoupper( $insert_after ) == strtoupper( $block['title'] ) ) {
									$new_order[] = $c_item;
								}
							}
						}

					}

				}

			}

		}

	}

	// Refresh menu order numbers
	$menu_order = 0;
	foreach ( $new_order as $key => $item ) {
		$menu_order ++;
		$new_order[ $key ]->menu_order = $menu_order;
	}

	return $new_order;

}

add_filter( 'wp_get_nav_menu_items', 'add_pagebuilder_nav_menu_items', 10, 3 );


function get_language_switcher() {

	$languages = icl_get_languages( 'skip_missing=0&orderby=code' );

	if ( count( $languages ) > 1 ) {


		$active_language = [];
		$build           = '<ul class="sub-menu">';

		foreach ( $languages as $l ) {

			if ( $l['active'] ) {
				$active_language = $l;
				continue;
			}

			$build .= '<li><a href="' . $l['url'] . '">';

			if ( $l['country_flag_url'] ) {
				$build .= '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" /> ';
			}

			$build .= $l['native_name'];
			$build .= '</a></li>';

		}

		$build .= '</ul>';

		return '
		<li class="item-language-switch menu-item-has-children">
			<a href="#">
			' . ( ( $active_language['country_flag_url'] ) ? '<img src="' . $active_language['country_flag_url'] . '" height="12" alt="' . $active_language['language_code'] . '" width="18" />' : '' ) . '
			' . $active_language['native_name'] . '</a>
			' . $build . '
			</a>
		</li>';

	}

	return false;

}