<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class FeaturedImage extends AC\Column\Post\FeaturedImage
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Meta( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\FeaturedImage( $this );
	}

	public function editing() {
		return new Editing\Model\Post\FeaturedImage( $this );
	}

	public function export() {
		return new Export\Model\AttachmentURLFromAttachmentId( $this );
	}

}