<?php
$key_values = get_field( 'key_values' );
if ( $key_values ) {
	?>
    <div class="section">
        <div class="section__content">
            <div class="row align-center">
                <div class="columns small-12 large-10 xlarge-8">
                    <div class="row text-center small-up-1 medium-up-3 align-center features__list features--numbers">
						<?php
						foreach ( $key_values as $key => $key_value ) {
							?>
                            <div class="column">
                                <div class="features__item">
                                    <div class="features__value"><?php echo $key_value['value']; ?></div>
                                    <p class="features__name"><?php echo $key_value['description']; ?></p>
                                </div>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}
?>