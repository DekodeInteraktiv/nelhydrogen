<?php
$title    = get_field( 'title' );
$popup_id = 'person-desc-' . get_the_ID();
$image_id = get_post_thumbnail_id();
?>
<div class="PersonCard">

    <a title="<?php _e( 'Read mini CV', 'nel' ); ?>" class="open-popup-link-person PersonCard__link"
       data-mfp-src="#<?php echo $popup_id; ?>" href="<?php echo get_permalink(); ?>">
		<?php if ( $image_id ) { ?>
            <div class="PersonCard__image">
				<?php echo wp_get_attachment_image( $image_id, 'large' ); ?>
            </div>
		<?php } ?>
        <div class="PersonCard__text">
            <strong class="PersonCard__name"><?php echo the_title(); ?></strong>
            <div class="PersonCard__title"><?php echo $title; ?></div>
        </div>
    </a>

</div>

<?php
/**
 * Popup content
 */
?>
<div class="mfp-hide mfp-card" id="<?php echo $popup_id; ?>">
    <div class="mfp-card__inner">
        <h3 class="mfp-card__title"><?php the_title(); ?></h3>
        <div class="mfp-card__content wysiwyg"><?php the_content(); ?></div>
        <footer class="mfp-card__footer">
            <a title="<?php _e( 'Close', 'nel' ); ?>" href="#"
               class="modal-close btn btn-d btn-small"><?php _e( 'Close', 'nel' ); ?></a>
        </footer>
    </div>
</div>