<?php

namespace ReviewPlugin\Front;

use ReviewPlugin\Constants\Commons\Actions;
use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Forms\Default_Values;
use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Enum;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Front\Outputs\Factory\Output_Factory;
use ReviewPlugin\Front\Outputs\Impl\Short_Code;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\Factory\View_Factory;
use ReviewPlugin\Path_Manager;

/**
 * Output_Controller
 */
final class Output_Controller {

	/**
	 * @var string
	 */
	const STYLE_NAME = 'front';

	/**
	 * @var Path_Manager
	 */
	private $pm;

	/**
	 * __construct
	 *
	 * @param Path_Manager $pm
	 */
	function __construct( Path_Manager $pm ) {
		$this->pm = $pm;
		$this->hooks();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function hooks(): void {
		/** shortcode */
		add_shortcode(
			Short_Code::NAME,
			array(
				$this,
				'output_shortcode'
			)
		);
		/** the_content */
		add_filter(
			Actions::THE_CONTENT,
			array(
				$this,
				'insert_into_content'
			)
		);
		/** style */
		add_action(
			Actions::WP_ENQUEUE_SCRIPTS,
			array(
				$this,
				'style'
			)
		);
	}

	/**
	 * style
	 *
	 * @return void
	 */
	public function style(): void {
		wp_enqueue_style(
			self::STYLE_NAME,
			$this->pm->getFrontStylePath(
				self::STYLE_NAME
			)
		);
	}

	/**
	 * output_shortcode
	 *
	 * @param mixed $attrs
	 * @return string
	 */
	public function output_shortcode( $attrs ): string {
		$content = '';
		$post_id = get_the_ID();
		if( !$this->is_enable_review( $post_id ) ) {
			return $content;
		};
		$location_enum = $this->get_location_enum( $post_id );
		if ( !$location_enum->is_shortcode() ) {
			return $content;
		}
		$output_instance = $this->get_output_instance( $post_id, $location_enum );
		return $output_instance->adjust( $content );
	}

	/**
	 * insert_into_content
	 *
	 * @param mixed $output
	 * @return string
	 */
	public function insert_into_content( $content ): string {
		$post_id = get_the_ID();
		if( !$this->is_enable_review( $post_id ) ) {
			return $content;
		};
		$location_enum = $this->get_location_enum( $post_id );
		if ( !$location_enum->is_contents() ) {
			return $content;
		}
		$output_instance = $this->get_output_instance( $post_id, $location_enum );
		return $output_instance->adjust( $content );
	}

	/**
	 * is_enable_review
	 *
	 * @param string $post_id
	 * @return bool
	 */
	private function is_enable_review( $post_id ): bool {
		$value = get_post_meta(
			$post_id,
			Post_Meta::ENABLE_REVIEW,
			true
		);
		// TODO:なんとかしたい
		if ( is_null( $value ) || is_bool( $value ) || '' === $value ) {
			$value = Default_Values::REVIEW_OPTIONS[Post_Meta::ENABLE_REVIEW];
		}
		$enable_review_enum = Enum::factory(
			On_Off::class,
			$value
		);
		if ( $enable_review_enum->equals( On_Off::ON ) ) {
			return true;
		}
		return false;
	}

	/**
	 * get_location_enum
	 *
	 * @param string $post_id
	 * @return Location
	 */
	private function get_location_enum( $post_id ): Location {
		$value = get_post_meta(
			$post_id,
			Post_Meta::LOCATION,
			true
		);
		// TODO:なんとかしたい
		if ( is_null( $value ) || is_bool( $value ) || '' === $value ) {
			$value = Default_Values::REVIEW_OPTIONS[Post_Meta::LOCATION];
		}
		return Enum::factory(
			Location::class,
			$value
		);
	}

	/**
	 * get_output_instance
	 *
	 * @param string $post_id
	 * @param Location location_enum
	 * @return Output
	 */
	private function get_output_instance( string $post_id, Location $location_enum ): Output {
		$value = get_post_meta(
			$post_id,
			Post_Meta::DESIGN,
			true
		);
		// TODO:なんとかしたい
		if ( is_null( $value ) || is_bool( $value ) || '' === $value ) {
			$value = Default_Values::REVIEW_OPTIONS[Post_Meta::DESIGN];
		}
		$view =  View_Factory::create(
			Enum::factory(
				Design::class,
				$value
			)
		);
		return Output_Factory::create(
			Enum::factory(
				Location::class,
				$location_enum->getId()
			),
			$view,
			$post_id
		);
	}
}

