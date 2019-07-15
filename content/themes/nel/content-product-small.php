<div class="flag flag--product">
    <div class="flag__image">
		<?php
		$image_id = get_post_thumbnail_id();
		$bgset    = hey_get_attachment_image_bgset( $image_id, 'full' );
		?>
        <a class="flag__image-link" title="<?php _e( 'View product', 'nel' ); ?>" href="<?php the_permalink(); ?>">
            <div role="img" class="aspect small-aspect-square lazyload bgimg-contain" <?php echo $bgset; ?>></div>
        </a>
    </div>
    <div class="flag__body">
		<?php
		$label = get_field( 'label' );
		if ( $label ) {
			echo '<p class="flag__label label">' . $label . '</p>';
		} else {
			echo '<p class="flag__label flag__label--empty label">&nbsp;</p>';
		}
		?>
        <h3 class="flag__title">
            <a class="flag__link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </h3>
        <a title="<?php _e( 'Open', 'nel' ); ?> <?php esc_attr( get_the_title() ); ?>"
           href="<?php the_permalink(); ?>"><?php _e( 'View product', 'nel' ); ?></a>
    </div>
</div>