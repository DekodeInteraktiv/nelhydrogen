<?php
$attachments = get_post_meta( get_the_ID(), 'cision_files', true );
$terms       = wp_get_post_terms( get_the_ID(), 'cision_category' );
$term_links  = array_map( function ( $item ) {
	return '<a href="' . get_term_link( $item ) . '">' . $item->name . '</a>';
}, $terms );
?>
<article id="post-<?php the_ID(); ?>" class="Cover">

    <div class="Cover__text">

        <div class="Cover__meta">
			<?php
			if ( $term_links ) {
				echo '<span class="Cover__terms">';
				echo implode( ', ', $term_links );
				echo '</span>';
			}
			?>
            <time class="Cover__published meta"
                  datetime="<?php echo $post->post_date_gmt; ?>"><?php echo get_the_date(); ?></time>
        </div>

        <a title="<?php _e( 'Read more', 'nel' ); ?>" class="Cover__link" href="<?php the_permalink(); ?>">
            <h3 class="Cover__title"><?php the_title(); ?></h3>
            <span class="Cover__more"><?php _e( 'Read more', 'nel' ); ?></span>
        </a>

    </div>

    <div class="Cover__extras">
		<?php
		if ( $attachments ) {
			?>
            <ul class="Cover__documents List List--horizontal List--small">
                <li class="List__item List__item--title">
                    <strong><?php _e( 'Related documents', 'nel' ); ?></strong>
                </li>
				<?php
				foreach ( $attachments as $key => $attachment ) {
					echo '<li class="List__item"><a class="List__link icon-file" title="' . __( 'Download', 'nel' ) . '" target="_blank" href="' . $attachment['url'] . '">' . $attachment['title'] . ' (' . pathinfo( $attachment['filename'], PATHINFO_EXTENSION ) . ')</a></li>';
				}
				?>
            </ul>
			<?php
		}
		?>
    </div>


</article>