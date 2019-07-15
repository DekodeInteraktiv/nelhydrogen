<?php
$terms      = wp_get_post_terms( get_the_ID(), 'category' );
$term_links = array_map( function ( $item ) {
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
            <div class="Cover__excerpt"><?php the_excerpt(); ?></div>
            <span class="Cover__more"><?php _e( 'Read more', 'nel' ); ?></span>
        </a>

    </div>

</article>