<?php

namespace ReviewPlugin\Front\Views;

/**
 * View
 */
interface View {

	/**
	 * __construct
	 */
	function __construct();

	/**
	 * create
	 *
	 * @param array $data
	 * @return string
	 */
	function create( array $data ): string;
}
