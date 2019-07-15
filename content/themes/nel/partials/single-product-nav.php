<div data-sticky-container>
    <div class="StickySubnav container sticky" data-sticky data-margin-top="0" data-anchor="product-body"
         data-sticky-on="medium">
        <div class="row">
            <div class="columns small-12">
                <ul data-magellan data-offset="80" data-animation-easing="swing" data-animation-duration="500"
                    class="StickySubnav__list">
                    <li class="StickySubnav__top">
                        <a class="scrollto StickySubnav__top-button" href="#post-<?php the_ID(); ?>"><span
                                    class="icon-arrow-up"></span></a>
                    </li>
                    <li class="StickySubnav__label">
                        <span class="hide-for-medium"><?php _e( 'Jump to', 'nel' ); ?></span>
                        <span class="show-for-medium"><?php the_title(); ?></span>
                    </li>
					<?php

					$blocks = get_field( 'blocks' );
					if ( $blocks ) {
						foreach ( $blocks as $block ) {
							if ( ! isset( $block['enable_navigation'] ) || ! isset( $block['title'] ) || ( isset( $block['status'] ) && $block['status'] == 'hidden' ) ) {
								continue;
							}
							if ( ( $block['enable_navigation'] || $block['acf_fc_layout'] == 'table' ) && $block['title'] ) {
								?>
                                <li class="StickySubnav__item">
                                    <a class="StickySubnav__link"
                                       href="#<?php echo sanitize_title( $block['title'] ); ?>"><?php echo $block['title']; ?></a>
                                </li>
								<?php
							}
						}
					}

					// Features
					$features = get_field( 'features' );
					if ( $features ) {
						?>
                        <li class="StickySubnav__item">
                            <a class="StickySubnav__link" href="#features"><?php _e( 'Features', 'nel' ); ?></a>
                        </li>
						<?php
					}

					// Applications
					$applications = get_field( 'applications_list' );
					if ( $applications ) {
						?>
                        <li class="StickySubnav__item">
                            <a class="StickySubnav__link" href="#applications"><?php _e( 'Applications', 'nel' ); ?></a>
                        </li>
						<?php
					}

					// Resources
					$resources = get_field( 'resources' );
					if ( $resources ) {
						?>
                        <li class="StickySubnav__item">
                            <a class="StickySubnav__link" href="#resources"><?php _e( 'Resources', 'nel' ); ?></a>
                        </li>
						<?php
					}

					// Contact
					$product_wizard_contact_form = get_field( 'product_wizard_contact_form', 'options' );
					if ( $product_wizard_contact_form ) :

						?>
                        <li class="StickySubnav__item StickySubnav__item--button">
                            <button class="StickySubnav__button open-popup-link btn btn-a btn-small"
                                    data-mfp-src="#gravity-form-popup-<?php echo $product_wizard_contact_form; ?>">
                                <span class="show-for-large"><?php _e( 'Contact us for a quote', 'nel' ); ?></span>
                                <span class="hide-for-large"><?php _e( 'Contact us', 'nel' ); ?></span>
                            </button>
                            <div id="gravity-form-popup-<?php echo $product_wizard_contact_form; ?>"
                                 class="mfp-hide mfp-contact-form">
								<?php
								$fields = array(
									'product_id'   => get_the_ID(),
									'product_name' => get_the_title(),
								);
								gravity_form( $product_wizard_contact_form, false, false, false, $fields, true, 100 );
								?>
                            </div>
                        </li>
					<?php

					endif;

					?>
                </ul>
            </div>
        </div>
    </div>
</div>