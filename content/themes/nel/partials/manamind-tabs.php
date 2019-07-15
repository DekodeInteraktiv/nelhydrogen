<div class="tab-scroller">
    <div class="tab-scroller__content">
        <ul class="tabs" data-tabs id="manamind-tabs">
			<?php /*<li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Broker statistics</a></li> */ ?>
            <li class="tabs-title is-active"><a title="<?php _e( 'Last 10 trades', 'nel' ); ?>"
                                                href="#panel2"><?php _e( 'Last 10 trades', 'nel' ); ?></a></li>
            <li class="tabs-title"><a title="<?php _e( 'Share performance', 'nel' ); ?>"
                                      href="#panel3"><?php _e( 'Share performance', 'nel' ); ?></a></li>
            <li class="tabs-title"><a title="<?php _e( 'Historical profit', 'nel' ); ?>"
                                      href="#panel4"><?php _e( 'Historical profit', 'nel' ); ?></a></li>
        </ul>
    </div>
</div>

<div class="tabs-content" data-tabs-content="manamind-tabs">

	<?php /*
	Not working atm
	<div class="tabs-panel is-active" id="panel1">
		<?php get_manamind_feed('broker_statistics'); ?>
	</div> */ ?>

    <div class="tabs-panel is-active" id="panel2">
		<?php get_manamind_feed( 'trades' ); ?>
    </div>

    <div class="tabs-panel" id="panel3">
		<?php get_manamind_feed( 'performance' ); ?>
    </div>

    <div class="tabs-panel" id="panel4">
		<?php get_manamind_feed( 'history' ); ?>
    </div>

    <p class="markets-disclaimer text-center small"
       data-string="<?php _ex( 'Market data is at least %delay% minutes delayed. All prices are presented in %currency%.<br>%author%', 'OMS feed disclaimer', 'nel' ); ?>"
       data-xml="//ir.asp.manamind.com/products/xml/disclaimer.do?key=nel&amp;lang=en"></p>

</div>