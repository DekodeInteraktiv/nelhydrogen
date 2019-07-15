<div id="post-<?php the_ID(); ?>" class="item-search">
    <header>
		<span class="meta">
			<span class="post-date-label"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<?php
			$label = nel_get_post_type_label( get_post_type() );
			if ( $label ) {
				echo ' &mdash; ' . $label;
			}
			?>
		</span>
        <h3><a title="<?php _e( 'Open', 'nel' ); ?> <?php echo esc_attr( get_the_title() ); ?>"
               href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </header>
    <div class="excerpt lead"><?php the_excerpt(); ?></div>
    <a title="<?php _e( 'Read more', 'nel' ); ?>" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'nel' ); ?>
        &hellip;</a>
</div>
