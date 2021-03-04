<?php

namespace ReviewPlugin\Admin\Widgets\Impl;

use WP_Widget;
use ReviewPlugin\Constants\Fields\Widgets\Options_Review_Lists;

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
		// 初期設定
		$title = ! empty( $instance[Options_Review_Lists::TITLE] ) ? $instance[Options_Review_Lists::TITLE] : __( '新しいタイトル', 'text_domain' );
?>

		<p>
			<label for="<?php echo $this->get_field_id( Options_Review_Lists::TITLE ); ?>">タイトル:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( Options_Review_Lists::TITLE ); ?>" name="<?php echo $this->get_field_name( Options_Review_Lists::TITLE ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
}
