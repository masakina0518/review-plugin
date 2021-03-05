<?php

namespace ReviewPlugin\Admin\Widgets\Impl;

use WP_Widget;
use ReviewPlugin\Constants\Fields\Widgets\Options_Review_Lists;
use ReviewPlugin\Constants\Forms\Default_Values;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Date;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Design;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Order;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Score_Type;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Source;

/**
 * Review_lists
 *
 * @see https://wpdocs.osdn.jp/WordPress_%E3%82%A6%E3%82%A3%E3%82%B8%E3%82%A7%E3%83%83%E3%83%88_API
 */
final class Review_lists extends WP_Widget {

	/**
	 * @var string
	 */
	const ID_BASE = 'review_lists';

	/**
	 * @var string
	 */
	const TITLE = 'Review Lists Widget';

	/**
	 * @var string
	 */
	const DESCRIPTION = 'Review Lists表示するWidgetです';

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			self::ID_BASE,
			self::TITLE,
			array(
				'description' => self::DESCRIPTION
			)
		);
	}

	/**
	 * ウィジェットのフロントエンド表示
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     ウィジェットの引数
	 * @param array $instance データベースの保存値
	 */
	public function widget( $args, $instance ): void {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo __( '世界のみなさん、こんにちは', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * バックエンドのウィジェットフォーム
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance データベースからの前回保存された値
	 */
	public function form( $instance ): void {
		$form = [];
		$form = $this->marge_options_to_default( $form, $instance );
?>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::TITLE ); ?>">タイトル:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( Options_Review_Lists::TITLE ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::TITLE ); ?>" type="text" value="<?php echo esc_attr( $form[Options_Review_Lists::TITLE] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::AMOUNT ); ?>">Amount</label>
			<input class="widefat" id="<?php echo $this->get_field_id( Options_Review_Lists::AMOUNT ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::AMOUNT ); ?>" type="text" value="<?php echo esc_attr( $form[Options_Review_Lists::AMOUNT] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::SOURCE ); ?>">Revie Sources</label>
			<select id="<?php echo $this->get_field_id( Options_Review_Lists::SOURCE ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::SOURCE ); ?>">
				<?php foreach( Widgets_Source::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Options_Review_Lists::SOURCE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::DATE ); ?>">Review Date</label>
			<select id="<?php echo $this->get_field_id( Options_Review_Lists::DATE ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::DATE ); ?>">
				<?php foreach( Widgets_Date::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Options_Review_Lists::DATE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::ORDER ); ?>">Order</label>
			<select id="<?php echo $this->get_field_id( Options_Review_Lists::ORDER ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::ORDER ); ?>">
				<?php foreach( Widgets_Order::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Options_Review_Lists::ORDER] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::DESIGN ); ?>">Design</label>
			<select id="<?php echo $this->get_field_id( Options_Review_Lists::DESIGN ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::DESIGN ); ?>">
				<?php foreach( Widgets_Design::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Options_Review_Lists::DESIGN] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::SCORE_TYPE ); ?>">Score Type</label>
			<select id="<?php echo $this->get_field_id( Options_Review_Lists::SCORE_TYPE ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::SCORE_TYPE ); ?>">
				<?php foreach( Widgets_Score_Type::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Options_Review_Lists::SCORE_TYPE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>
		</p>


<?php
	}

	/**
	 * ウィジェットフォームの値を保存用にサニタイズ
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance 保存用に送信された値
	 * @param array $old_instance データベースからの以前保存された値
	 *
	 * @return array 保存される更新された安全な値
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * marge_options_to_default
	 *
	 * @param array $data
	 * @param array $instance
	 * @return array
	 */
	private function marge_options_to_default( array $data, array $instance ): array {
		foreach ( Default_Values::WIDGESTS_REVIEW_LISTS as $field => $value ) {
			$data[$field] = ! empty( $instance[$field] ) ? $instance[$field] : $value;
		}
		return $data;
	}
}
