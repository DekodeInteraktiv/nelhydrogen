<?php

/*
 * This file is part of Mustache.php.
 *
 * (c) 2010-2017 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Mustache Template Loader interface.
 */
interface Mustache_Loader {
	/**
	 * Load a Template by name.
	 *
	 * @param  string $name
	 *
	 * @return string|Mustache_Source Mustache Template source
	 * @throws Mustache_Exception_UnknownTemplateException If a template file is not found
	 *
	 */
	public function load( $name );
}
