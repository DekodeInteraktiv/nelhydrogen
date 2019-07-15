<?php
$title = get_tax_type_object_title();
?>
<?php get_header(); ?>

    <article class="Article">

        <header class="Article__header">
            <h1 class="Article__title"><?php echo $title; ?></h1>
			<?php get_template_part( 'partials/taxonomy-nav' ); ?>
        </header>

		<?php

		/**
		 * List people
		 */

		if ( have_posts() ) :
			echo '<div class="Article__content container">';
			echo '<div class="board-list row small-up-1 medium-up-2 large-up-3">';
			while ( have_posts() ) : the_post();
				echo '<div class="board-list__item column">';
				get_template_part( 'loop', 'person' );
				echo '</div>';
			endwhile;
			echo '</div>';
			echo '</div>';
		endif;

		?>


    </article>

<?php get_footer(); ?>