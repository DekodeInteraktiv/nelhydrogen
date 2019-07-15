<?php

$model_id = get_field( 'key_features_model' );
if ( $model_id ) {
	$model = do_shortcode( '[devvn_ihotspot id="' . $model_id . '"]' );
	if ( $model ) {

		// $model_post = get_post($model_id);
		// $pin_data = maybe_unserialize($model_post->post_content);
		// if (is_array($pin_data)) {
		//   echo '<pre>';
		//   print_r($pin_data);
		//   echo '</pre>';
		// }

		?>
        <div id="key-features" class="section">
            <div class="section__content text-center">
                <header class="row section__header">
                    <div class="columns">
                        <h3 class="section__title"><?php _e( 'Key features', 'nel' ); ?></h3>
                    </div>
                </header>
                <div class="row align-center">
                    <div class="columns medium-8">
						<?php echo $model; ?>
                    </div>
                </div>
            </div>
        </div>
		<?php

	}
}
