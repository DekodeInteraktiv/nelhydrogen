<?php

$c_query = new WP_Query( array(
	'post_type'      => 'cision_post',
	'posts_per_page' => 3
) );

if ( $c_query->have_posts() ) {
	echo '<div class="MiniFeed">';
	while ( $c_query->have_posts() ) {
		$c_query->the_post();
		?>
        <div class="MiniFeed__item">
            <a class="MiniFeed__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <p class="MiniFeed__content">
                <time class="MiniFeed__time"
                      datetime="<?php echo $post->post_date_gmt; ?>"><?php echo get_the_date(); ?></time>
            </p>
        </div>
		<?php
	}
	echo '</div>';
}

?>