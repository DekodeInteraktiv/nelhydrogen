<?php

// @ini_set( 'upload_max_size' , '128MB' );
// @ini_set( 'post_max_size', '128MB');
// @ini_set( 'memory_limit', '128MB' );

/* WordPress Config and Cleanup */
require_once( 'library/config/cleanup.php' );
require_once( 'library/config/theme-support.php' );
require_once( 'library/config/enqueue-scripts.php' );
require_once( 'library/config/custom-post-types.php' );
require_once( 'library/config/media.php' );
require_once( 'library/config/tinymce.php' );

/* Plugin Config */
require_once( 'library/config/plugins/wpseo.php' );
require_once( 'library/config/plugins/acf.php' );
require_once( 'library/config/plugins/gravityforms.php' );
require_once( 'library/config/plugins/wprocket.php' );
require_once( 'library/config/plugins/wpml.php' );

/* Components Setup */
require_once( 'library/components/navigation.php' );

/* Other */
require_once( 'library/helpers.php' );
require_once( 'library/shortcodes.php' );
require_once( 'library/frontend.php' );
require_once( 'library/oms-feeds.php' );
require_once( 'library/ajax.php' );
require_once( 'library/mustache.php' );