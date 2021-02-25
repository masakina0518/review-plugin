<?php

namespace ReviewPlugin\Admin\Views;

/**
 * View_Welcome
 */
final class View_Welcome {

	/**
	 * @var string
	 */
	const TITLE = 'Welcome';

	/**
	 * @var string
	 */
	const SLUG = 'review_plugin_welcome';

	/**
	 * __construct
	 */
	function __construct() {
		$data = [];
		$data = $this->initialize( $data );
		$this->display( $data );
	}

	/**
	 * initialize
	 *
	 * @param array $data
	 * @return array
	 */
	private function initialize( array $data ): array {
		return $data;
	}

	/**
	 * display
	 *
	 * @return void
	 */
	public function display( array $data ): void {
		extract( $data );
	?>

	<div class="wrap">
		<h1><?php echo self::TITLE; ?></h1>
	</div>
<?php
	}
}
