<?php
$industrial_application = get_field( 'industrial_application', 'options' );
$flow_rates             = get_field( 'flow_rates', 'options' );
$recommended_products   = '';
?>
<div class="section bg-gray">
    <div class="row align-center">
        <div class="column large-8">
            <div class="section__content">
                <div class="product-wizard">
                    <header class="section__header text-center">
                        <h3><?php _e( 'Product wizard', 'nel' ); ?></h3>
                        <p class="lead"><?php _e( 'Let us help you pair the right hydrogen generation solution with your operation.', 'nel' ); ?></p>
                    </header>
                    <div class="text-center">
                        <button data-mfp-src="#product-wizard"
                                class="btn btn-a product-wizard__get-started open-popup-link-inline"><?php _e( 'Get started!', 'nel' ); ?></button>
                    </div>
                    <div id="product-wizard" class="product-wizard mfp-hide mfp-product-wizard">

                        <div data-scope="ProductWizard" class="product-wizard__content">
                            <h3 class="product-wizard__title"><?php _e( 'Product wizard', 'nel' ); ?></h3>

                            <div class="product-wizard__section main-select-wrap">
                                <label for="pw-industrial-application">
                                    <h4 class="product-wizard__section-title">
                                        1. <?php _e( 'What is your industrial application?', 'nel' ); ?></h4>
                                </label>
                                <div class="product-wizard__section-content">
                                    <select id="pw-industrial-application" class="main-select">
                                        <option disabled selected><?php _e( 'Please select', 'nel' ); ?></option>
										<?php
										foreach ( $industrial_application as $key => $application ) {
											echo '<option value="' . esc_attr( $application['title'] ) . '">' . $application['title'] . '</option>';
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="product-wizard__section child-select-wrap">
                                <label for="pw-max-flow">
                                    <h4 class="product-wizard__section-title">
                                        2. <?php _e( 'What is your maximum required hydrogen flow rate?', 'nel' ); ?></h4>
                                </label>
                                <div class="product-wizard__section-content">
                                    <select id="pw-max-flow" class="child-select">
                                        <option disabled selected><?php _e( 'Please select', 'nel' ); ?></option>
										<?php
										foreach ( $flow_rates as $key => $flow_rate ) {
											if ( ! $flow_rate['products'] ) {
												$key = 'none';
											}
											echo '<option value="' . $key . '">' . $flow_rate['title'] . '</option>';
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="product-wizard__section product-wizard__products">
                                <h4 class="product-wizard__section-title">
                                    3. <?php _e( 'Recommended product', 'nel' ); ?></h4>
                                <div class="product-wizard__section-content">
									<?php
									global $post;
									foreach ( $flow_rates as $key => $flow_rate ) {
										if ( $flow_rate['products'] ) {
											$pids = array_map( function ( $prod ) {
												return $prod->ID;
											}, $flow_rate['products'] );
											echo '<div class="product-wizard__list rec-prod rec-prod-' . $key . '" data-products="' . implode( ',', $pids ) . '">';
											foreach ( $flow_rate['products'] as $key => $post ) {
												setup_postdata( $post );
												echo '<div data-id="' . $post->ID . '" class="product-wizard__product">';
												get_template_part( 'content-product', 'tiny' );
												echo '</div>';
											}
											echo '</div>';
										}
									}
									wp_reset_postdata();
									echo '<div class="rec-prod rec-prod-none">
                    <h3>3. ' . __( 'RFQ, please consult', 'nel' ) . '</h3>
                  </div>';
									?>
                                </div>
                            </div>

                            <div class="product-wizard__section product-wizard__contact text-center">
                                <div class="product-wizard__section-content">
									<?php
									$product_wizard_contact_form = get_field( 'product_wizard_contact_form', 'options' );
									if ( $product_wizard_contact_form ) {
										gravity_form_enqueue_scripts( absint( $product_wizard_contact_form ), true );
										?>
                                        <a class="pw-ajax-popup-link btn btn-c"
                                           href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_ajax_form&amp;form_id=<?php echo $product_wizard_contact_form; ?>">
                                            <span><?php _e( 'Contact us for a quote', 'nel' ); ?></span>
                                        </a>
										<?php
									}
									?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>