<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <h3 class="h1"><?php echo _x( 'Search', 'label', 'nel' ) ?></h3>
        <input type="search" class="search-field h1"
               placeholder="<?php echo esc_attr_x( 'Type and hit enter', 'placeholder', 'nel' ) ?>"
               value="" name="s"
               title="<?php echo esc_attr_x( 'Search for:', 'label', 'nel' ) ?>"/>
    </label>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'nel' ) ?>"/>
</form>