<?php

namespace ReviewPlugin\Admin\Custom\Fields;

use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Constants\Items\Review_Type;

/**
 * Review_Options
 */
class Review_Options {

	/**
	 * @var array
	 */
	private $default = [
		Post_Meta::ENABLE_REVIEW => On_Off::OFF,
		Post_Meta::USE_POST_TITLE => On_Off::OFF,
		Post_Meta::REVIEW_TYPE => Review_Type::EDITOR_REVIEW_VISITOR_RATINGS,
	];

	/**
	 * __construct
	 */
	function __construct() {
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'post' ) );
	}

	/**
	 * add_meta_box
	 *
	 * @return void
	 */
	public function add_meta_box(): void {
		add_meta_box( 'book_setting', '本の情報', array( $this, 'display' ), array( 'post', 'page' ), 'advanced');
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	private function make_default_data(): array {
		$data['form'] = $this->default;
		// TODO:ここでWP_Optionsからデフォルト値を取得
		return $data;
	}

	/**
	 * post
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function post( $post_id ) {
		$data = $this->make_default_data();
		$post_data = stripslashes_deep( $_POST );
		if ( $post_data ) {
			foreach( $data['form'] as $field => $value ) {
				$update_val = $value;
				if ( array_key_exists( $field, $post_data ) ) {
					$update_val = $post_data[$field];
				}
				update_post_meta( $post_id, $field, $update_val );
			}
		}

		// if(!empty($_POST['book_name'])){ //題名が入力されている場合
		// 	update_post_meta($post_id, 'book_name', $_POST['book_name'] ); //値を保存
		// }else{ //題名未入力の場合
		// 	delete_post_meta($post_id, 'book_name'); //値を削除
		// }

		// if(!empty($_POST['book_author'])){
		// 	update_post_meta($post_id, 'book_author', $_POST['book_author'] );
		// }else{
		// 	delete_post_meta($post_id, 'book_author');
		// }

		// if(!empty($_POST['book_price'])){
		// 	update_post_meta($post_id, 'book_price', $_POST['book_price'] );
		// }else{
		// 	delete_post_meta($post_id, 'book_price');
		// }

		// if(!empty($_POST['book_label'])){
		// 	update_post_meta($post_id, 'book_label', $_POST['book_label'] );
		// }else{
		// 	delete_post_meta($post_id, 'book_label');
		// }
	}
	/**
	 * display
	 *
	 * @return void
	 */
	public function display(): void {
?>

		<h2>ENABLE REVIEW</h2>
		<?php foreach ( On_Off::getEnums() as $enum ): ?>
			<label><input name="<?php echo Post_Meta::ENABLE_REVIEW ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), get_post_meta( get_the_ID() , Post_Meta::ENABLE_REVIEW, true ) ); ?> /><?php echo $enum->getName() ?></label>
			<br />
		<?php endforeach; ?>

		<hr>

		<div>
			<h2>GENERAL</h2>
			<h4>USE POST TITLE</h4>
			<label><input name="<?php echo Post_Meta::USE_POST_TITLE ?>" type="checkbox" value="<?php echo On_Off::ON ?>" <?php checked( On_Off::ON, get_post_meta( get_the_ID() , Post_Meta::USE_POST_TITLE, true ) ); ?> /><?php echo $enum->getName() ?></label>

			<br />
			<br />

			<h4>Review Type</h4>
            <select name="<?php echo Post_Meta::REVIEW_TYPE ?>" id="<?php echo Post_Meta::REVIEW_TYPE ?>">
				<?php foreach( Review_Type::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), get_post_meta( get_the_ID(), Post_Meta::REVIEW_TYPE, true ) ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
            </select>

			<br />
			<br />

		</div>

<?php
/*
	題名： <input type="text" name="book_name" value="<?php echo get_post_meta(get_the_ID() , 'book_name', true); ?>" size="50" />

		<br>
		作者： <input type="text" name="book_author" value="<?php echo get_post_meta(get_the_ID() , 'book_author', true); ?>" size="50" />

		<br>
		価格： <input type="text" name="book_price" value="<?php echo get_post_meta(get_the_ID() , 'book_price', true); ?>" size="50" />

		<br>
		<?php $book_label_check = '';
		if( get_post_meta(get_the_ID() ,'book_label',true) == "is-on" ) {
			$book_label_check = "checked";
		}//チェックされていたらチェックボックスの$book_label_checkの場所にcheckedを挿入
		?>

		ベストセラーラベル： <input type="checkbox" name="book_label" value="is-on" <?php echo $book_label_check; ?> >
 */ ?>
		<br>
<?php
	}

}

