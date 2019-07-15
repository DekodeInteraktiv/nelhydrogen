<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>

    <article id="post-<?php the_ID(); ?>">

		<?php get_template_part( 'partials/header' ); ?>

        <div class="container site-pad-bottom">

            <div class="row">

                <div class="columns small-12 large-6">
                    <ul class="division-list">
						<?php
						$divisions = get_field( 'divisions', 'options' );
						foreach ( $divisions as $key => $division ) {
							?>
                            <div class="division">
                                <h4 class="title"><?php echo $division['title']; ?></h4>
                                <p>
									<?php echo do_shortcode( '[email]' . $division['email'] . '[/email]' ); ?><br>
									<?php echo $division['phone']; ?><br>
									<?php echo $division['fax']; ?>
                                </p>
                                <div><?php echo $division['address']; ?></div>
                            </div>
							<?php
						}
						?>
                    </ul>
                </div>

                <div class="columns small-12 large-6 form-column">
					<?php
					get_template_part( 'partials/form', 'contact' );
					?>
                </div>

            </div>

        </div>

    </article>

<?php get_footer(); ?>