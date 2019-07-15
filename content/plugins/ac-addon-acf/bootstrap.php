<?php

require_once 'api.php';

AC\Autoloader::instance()->register_prefix( 'ACA\ACF', plugin_dir_path( ACA_ACF_FILE ) . 'classes/' );

AC\Autoloader\Underscore::instance()
                        ->add_alias( 'ACA\ACF\Column', 'ACA_ACF_Column' )
                        ->add_alias( 'ACA\ACF\Field', 'ACA_ACF_Field' );

$addon = new ACA\ACF\AdvancedCustomFields( ACA_ACF_FILE );
$addon->register();