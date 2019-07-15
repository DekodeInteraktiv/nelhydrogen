<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Settings;
use ACP\Sorting;

class AuthorName extends AC\Column\Post\AuthorName
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		if ( 'custom_field' === $this->get_user_setting_display() ) {
			return new Sorting\Model\Disabled( $this );
		}

		return new Sorting\Model\Post\AuthorName( $this );
	}

	public function editing() {
		if ( 'custom_field' === $this->get_user_setting_display() ) {
			return new Editing\Model\Disabled( $this );
		}

		return new Editing\Model\Post\Author( $this );
	}

	public function filtering() {
		if ( 'custom_field' === $this->get_user_setting_display() ) {
			return new Filtering\Model\Disabled( $this );
		}

		if ( 'roles' === $this->get_user_setting_display() ) {
			return new Filtering\Model\Post\Roles( $this );
		}

		return new Filtering\Model\Post\AuthorName( $this );
	}

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

	public function register_settings() {
		$this->add_setting( new Settings\Column\User( $this ) );
	}

	/**
	 * @return string
	 */
	private function get_user_setting_display() {
		/* @var AC\Settings\Column\User $setting */
		$setting = $this->get_setting( 'user' );

		return $setting->get_display_author_as();
	}

}