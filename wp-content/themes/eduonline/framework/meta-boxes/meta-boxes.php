<?php
class jws_theme_FrameworkMetaboxes {
	public function __construct(){
		global $smof_data;
		$this->data = $smof_data;
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
		add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
	}
	function admin_script_loader() {
		global $pagenow;
		if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php')) {
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_style('tb-metabox', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/css/metabox.css');
			wp_enqueue_style('colorpicker', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/css/colorpicker.css');

			wp_enqueue_script('jcolpick', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/js/colpick.js');
			wp_enqueue_script('tb-upload', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/js/upload.js');
			wp_enqueue_script('jquery-easytabs', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/js/jquery.easytabs.min.js');
			wp_enqueue_script('blog-tabs', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/js/blog.tab.js');
			wp_enqueue_script('meta-box', JWS_THEME_URI_PATH_FR.'/meta-boxes/assets/js/meta.box.js');
			wp_enqueue_script('media-upload');
			wp_enqueue_style('thickbox');
		}
	}
	public function add_meta_boxes()
	{
		$post_types = get_post_types( array( 'public' => true ) );
		$this->add_meta_box('post_options', __('Page Options','eduonline'), 'page');
		$this->add_meta_box('post_video', __('Video Settings','eduonline'), array('post','lp_course'));
		$this->add_meta_box('product_options', __('Product Options','eduonline'), 'product');
		$this->add_meta_box('post_audio', __('Audio Settings','eduonline'), 'post');
		$this->add_meta_box('post_quote', __('Quote Settings','eduonline'), 'post');
		$this->add_meta_box('post_link', __('Link Settings','eduonline'), 'post');
		$this->add_meta_box('post_testimonial', __('Testimonial Settings','eduonline'), 'testimonial');
		$this->add_meta_box('post_portfolio', __('Portfolio Settings','eduonline'), 'portfolio');
		$this->add_meta_box('post_team', __('Team Settings','eduonline'), 'team');
		$this->add_meta_box('post_event', __('Event Settings','eduonline'), 'event');
				
		$this->add_meta_box('post_classes', __('Class Settings','eduonline'), 'classes');
	}
	public function save_meta_boxes($post_id)
	{
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		foreach($_POST as $key => $value) {
			if(strstr($key, 'jws_theme_')) {
				update_post_meta($post_id, $key, $value);
			}
		}
	}
	public function add_meta_box($id, $label, $post_type)
	{
		add_meta_box(
		'jws_theme_' . $id,
		$label,
		array($this, $id),
		$post_type
		);
	}
	public function post_options()
	{
		$data = $this->data;
		include 'blog_options.php';
	}
	public function product_options()
	{
		include 'product_options.php';
	}
	public function post_video()
	{
		include 'post_video.php';
	}
	public function post_audio()
	{
		include 'post_audio.php';
	}
	public function post_quote()
	{
		include 'post_quote.php';
	}
	public function post_link()
	{
		include 'post_link.php';
	}
	public function post_testimonial()
	{
		include 'post_testimonial.php';
	}

	public function post_portfolio()
	{
		include 'post_portfolio.php';
	}

	public function post_team(){
		include 'post_team.php';
	}
	
	public function post_classes(){
		include 'post_classes.php';
	}
	public function post_event(){
		include 'post_event.php';
	}

	public function text($id, $label, $default, $desc = '')
	{
		global $post;
		$value = get_post_meta($post->ID, 'jws_theme_' . $id, true);
		if (!$value){
			$value = $default;
		}
		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<input type="text" id="jws_theme_' . $id . '" name="jws_theme_' . $id . '" value="' . $value . '" />';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}
	public function hidden($id){
		global $post;
		$html = '<input type="hidden" id="jws_theme_' . $id . '" name="jws_theme_' . $id . '" value="' . get_post_meta($post->ID, 'jws_theme_' . $id, true) . '" />';
		echo $html;
	}
	public function select($id, $label, $options,$defualt, $desc = '')
	{
		global $post;
		$html = null;
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<select id="jws_theme_' . $id . '" name="jws_theme_' . $id . '">';                
		$value = get_post_meta($post->ID, 'jws_theme_' . $id, true);
		$defualt = $value == '' ? $defualt ='global': $value;
                
		foreach($options as $key => $option) {
                    $selected = $defualt === (string)$key?'selected="selected"':null;
                    $html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
		}
		$html .= '</select>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function multiple($id, $label, $options, $desc = '')
	{
		global $post;

		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<select multiple="multiple" id="jws_theme_' . $id . '" name="jws_theme_' . $id . '[]">';
		foreach($options as $key => $option) {
			if(is_array(get_post_meta($post->ID, 'jws_theme_' . $id, true)) && in_array($key, get_post_meta($post->ID, 'jws_theme_' . $id, true))) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}

			$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
		}
		$html .= '</select>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function textarea($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<textarea class="widefat" style="max-width:480px" cols="30" rows="5" id="jws_theme_' . $id . '" name="jws_theme_' . $id . '">' . get_post_meta($post->ID, 'jws_theme_' . $id, true) . '</textarea>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function upload($id, $label, $desc = '')
	{
		global $post;
		$html = '';
		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<input name="jws_theme_' . $id . '" class="upload_field" id="jws_theme_' . $id . '" type="text" value="' . get_post_meta($post->ID, 'jws_theme_' . $id, true) . '" />';
		$html .= '<input class="jws_theme_upload_button button button-primary button-large" type="button" value="Browse" />';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}
	
	public function uploadM($id, $label, $desc = '')
	{
		global $post;
		$html = '';
		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<input name="jws_theme_' . $id . '" class="upload_field" id="jws_theme_' . $id . '" type="text" value="' . get_post_meta($post->ID, 'jws_theme_' . $id, true) . '" />';
		$html .= '<input class="jws_theme_upload_button multiple button button-primary button-large" type="button" value="Browse" />';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}
	public function input_date($id, $label, $default, $desc = '')
	{
		global $post;
		$value = get_post_meta($post->ID, 'jws_theme_' . $id, true);
		if (!$value){
			$value = $default;
		}
		$html = '';
		$html .= '<div id="jws_theme_metabox_field_'.$id.'" class="jws_theme_metabox_field">';
		$html .= '<label for="jws_theme_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		$html .= '<div class="field">';
		$html .= '<input type="date" id="jws_theme_' . $id . '" class="bt-date-picker" name="jws_theme_' . $id . '" value="' . $value . '" />';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';

		echo ''.$html;
	}
}
$metaboxes = new jws_theme_FrameworkMetaboxes();