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
	 * @return string
	 */
	function create(): string;
}
