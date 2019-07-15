<?php

$items = array(
	'details' => array(
		'title' => __( 'Details', 'nel' ),
		'url'   => '#details',
		'class' => 'scrollto'
	),
	'related' => array(
		'title' => __( 'Related products', 'nel' ),
		'url'   => '#related-products',
		'class' => 'scrollto'
	),
	'faq'     => array(
		'title' => __( 'FAQs', 'nel' ),
		'url'   => '#faq',
		'class' => 'scrollto'
	),
	'contact' => array(
		'title' => __( 'Contact', 'nel' ),
		'url'   => '#contact-form',
		'class' => 'open-popup-link'
	),
);

if ( ! have_posts() ) {
	unset( $items['related'] );
}

?>
<div id="section-nav-sticky-anchor"></div>
<div data-sticky-container>
    <div class="sticky section-nav" data-sticky data-margin-top="0" data-top-anchor="section-nav-sticky-anchor:bottom"
         data-sticky-on="medium">
        <ul class="section-nav__list">
			<?php
			foreach ( $items as $key => $item ) {
				echo '<li class="section-nav__item">
          <a class="section-nav__link ' . $item['class'] . '" href="' . $item['url'] . '">' . $item['title'] . '</a>
        </li>';
			}
			?>
        </ul>
        <div class="section-nav__control section-nav__control--prev"></div>
        <div class="section-nav__control section-nav__control--next"></div>
    </div>
</div>