<div class="flag flag--product">
    <div class="flag__image">
		<?php
		$image_id = get_post_thumbnail_id();
		$bgset    = hey_get_attachment_image_bgset( $image_id, 'full' );
		?>
        <div role="img" class="aspect small-aspect-square lazyload bgimg-contain" <?php echo $bgset; ?>></div>
    </div>
    <div class="flag__body">
        <h4 class="flag__title"><?php the_title(); ?></h4>
        <a class="small" href="<?php the_permalink(); ?>"><?php _e( 'View product', 'nel' ); ?></a>
    </div>
</div>