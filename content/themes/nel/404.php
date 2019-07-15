<?php get_header(); ?>

    <article>

        <div class="Panel">
            <div class="Panel__bg galaxy js-galaxy-404"></div>
            <div class="Panel__container container">
                <div class="Panel__row row align-middle align-center">
                    <div class="Panel__content columns large-10 xlarge-8 medium-text-center">
                        <h1><?php _e( 'Page not found', 'nel' ) ?></h1>
                        <p class="lead"><?php _e( 'The page you were trying to find does not exist.<br>This might be the result of a mistyped address or out-of-date link.', 'nel' ); ?></p>
                        <p><br><a class="btn btn-b"
                                  href="<?php echo home_url( '/' ); ?>"><?php _e( 'Return to the front page', 'nel' ); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </article>

<?php get_footer(); ?>