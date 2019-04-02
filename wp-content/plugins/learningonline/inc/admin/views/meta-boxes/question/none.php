<div class="learning-online-question" id="learning-online-question-<?php echo $this->id;?>" data-type="none" data-id="<?php echo $this->id;?>">
	<?php _e( 'Please select a type for this question'); ?>

	<p class="question-bottom-actions">
		<?php
		$buttons = apply_filters(
			'learning_online_question_bottom_buttons',
			array(
				'change_type' => learning_online_dropdown_question_types(array('echo' => false, 'id' => 'learning-online-dropdown-question-types-' . $this->id, 'selected' => 'none' ))
			),
			$this
		);
		echo join( "\n", $buttons );
		?>
	</p>
</div>