<article id="post-<?php the_ID(); ?>">

	<?php
	if ( ! get_field( 'old_product_layout' ) ) {
		get_template_part( 'partials/header', 'product' );
	} else {
		get_template_part( 'partials/header', 'product-old' );
	}
	?>

    <div id="product-body">

		<?php
		if ( ! get_field( 'old_product_layout' ) ) {
			get_template_part( 'partials/single-product-nav' );
		}
		?>

		<?php
		get_template_part( 'partials/block-key-values' );
		get_template_part( 'partials/blocks' );
		get_template_part( 'partials/block-features' );
		get_template_part( 'partials/block-key-features' );
		if ( ! get_field( 'old_product_layout' ) ) {
			echo '<hr class="section-divider" />';
			get_template_part( 'partials/related-products' );
		}

		?>

    </div>


</article>