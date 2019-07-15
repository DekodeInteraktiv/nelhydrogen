<article>

    <div class="Panel bg-black">
        <div class="Panel__bg galaxy js-galaxy-404"></div>
        <div class="Panel__container container">
            <div class="Panel__row row align-middle align-center">
                <div class="Panel__content columns large-10 xlarge-8 medium-text-center">
                    <h1><?php _e( 'Login required', 'nel' ); ?></h1>
					<?php echo get_the_password_form(); ?>
                </div>
            </div>
        </div>
    </div>

</article>