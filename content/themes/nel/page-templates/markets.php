<?php
/*
Template Name: Markets
*/
?>
<?php get_header(); ?>

    <article class="bg-black">

		<?php get_template_part( 'partials/header' ); ?>

		<?php
		// https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
		$terms = get_terms( array(
			'taxonomy'   => 'market',
			'hide_empty' => false,
			// 'parent' => 0,
		) );
		if ( $terms ) {
			$i = 0;
			foreach ( $terms as $term ) {
				// Show top level terms only
				if ( $term->parent != 0 ) {
					continue;
				}

				$excerpt = get_field( 'excerpt', $term );
				if ( ! $excerpt ) {
					$excerpt = apply_filters( 'the_content', $term->description );
				}

				$children = array();
				foreach ( $terms as $key => $child_term ) {
					if ( $child_term->parent == $term->term_id ) {
						$children[] = $child_term;
						unset( $terms[ $key ] ); // remove from loop to limit recursions
					}
				}

				?>
                <div class="section <?php echo $i == 0 ? 'section--nopad-top' : ''; ?>">
                    <div class="section__content">
                        <header class="row section__header medium-text-center">
                            <div class="columns">
                                <h3>
                                    <a title="<?php echo esc_attr( $term->name ); ?>"
                                       href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a>
                                </h3>
                            </div>
                        </header>
                        <ul class="row small-up-2 medium-up-4 large-up-5 text-center markets-list">
							<?php
							// children
							if ( ! empty( $children ) ) {

								$parent_term_link = get_term_link( $term );
								$section_title    = ( get_field( 'subsection_title', $term ) ) ? get_field( 'subsection_title', $term ) : __( 'Markets', 'nel' );

								foreach ( $children as $child ) {
									$image = get_field( 'featured_image', $child );
									if ( $image ) {
										$image = wp_get_attachment_image( $image, 'large' );
									} else {
										$image = '<img src="' . get_template_directory_uri() . '/images/MarketPlaceholder.png" alt="">';
									}
									$url_hash = ( $child->description ) ? '/#' . $child->slug : '';
									echo '<li class="columns markets-list__item">
                    <a class="markets-list__link" href="' . $parent_term_link . $url_hash . '">
                      <div class="markets-list__image">' . $image . '</div>
                      <h4 class="markets-list__title">' . $child->name . '</h4>
                    </a>
                  </li>';
								}

							}
							?>
                        </ul>
                    </div><!-- .section__content -->
                </div><!-- .section -->
				<?php

				$i ++;

			}
		}
		?>

    </article>

<?php get_footer(); ?>