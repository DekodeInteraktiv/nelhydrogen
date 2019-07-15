<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab66e434fad05e7f021d372161cdbe79
{
    public static $prefixesPsr0 = array (
        'x' => 
        array (
            'xrstf\\Composer52' => 
            array (
                0 => __DIR__ . '/..' . '/xrstf/composer-php52/lib',
            ),
        ),
    );

    public static $classMap = array (
        'OTGS_Assets_Handles' => __DIR__ . '/..' . '/otgs/ui/src/php/OTGS_Assets_Handles.php',
        'OTGS_Assets_Store' => __DIR__ . '/..' . '/otgs/ui/src/php/OTGS_Assets_Store.php',
        'OTGS_UI_Assets' => __DIR__ . '/..' . '/otgs/ui/src/php/OTGS_UI_Assets.php',
        'OTGS_UI_Loader' => __DIR__ . '/..' . '/otgs/ui/src/php/OTGS_UI_Loader.php',
        'WPML_WPSEO_Categories' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-categories.php',
        'WPML_WPSEO_Filters' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-filters.php',
        'WPML_WPSEO_Main_Factory' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-main-factory.php',
        'WPML_WPSEO_Metabox_Hooks' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-metabox-hooks.php',
        'WPML_WPSEO_Redirection' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-redirection.php',
        'WPML_WPSEO_XML_Sitemaps_Filter' => __DIR__ . '/../..' . '/classes/class-wpml-wpseo-xml-sitemaps-filter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitab66e434fad05e7f021d372161cdbe79::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitab66e434fad05e7f021d372161cdbe79::$classMap;

        }, null, ClassLoader::class);
    }
}
