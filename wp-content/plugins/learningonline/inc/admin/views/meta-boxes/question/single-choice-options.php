<div class="learning-online-question" id="learning-online-question-<?php echo $this->id;?>" data-type="<?php echo str_replace( '_', '-', $this->type );?>" data-id="<?php echo $this->id;?>">
	<p class="question-bottom-actions">
		<?php
		$top_buttons = array(
			'change_type' => learning_online_dropdown_question_types(array('echo' => false, 'id' => 'learning-online-dropdown-question-types-' . $this->id, 'selected' => $this->type ))
		);
		$top_buttons = apply_filters(
			'learning_online_question_top_buttons',
			$top_buttons,
			$this
		);
		echo join( "\n", $top_buttons );
		?>
	</p>
	<table class="lp-sortable lp-list-options" id="learning-online-list-options-<?php echo $this->id;?>">
		<thead>
		<th><?php _e( 'Answer Text', 'learningonline' ); ?></th>
		<th><?php _e( 'Is Correct?', 'learningonline' ); ?></th>
		<th width="20"></th>
		<?php if ( $this->type == 'single_choice' ): ?>
			<th width="20"></th>
		<?php endif;?>
		</thead>
		<tbody>

		<?php $answers = $this->answers; if ( $answers ): ?>
			<?php foreach ( $answers as $answer ): ?>
				<?php
				$value = $this->_get_option_value( $answer['value'] );
				$id = $value;
				?>

				<?php do_action( 'learning_online_before_question_answer_option', $this ); ?>

				<tr class="lp-list-option lp-list-option-<?php echo $id;?>" data-id="<?php echo $id;?>">
					<td>
						<input class="lp-answer-text no-submit key-nav" type="text" name="learning_online_question[<?php echo $this->id; ?>][answer][text][]" value="<?php echo esc_attr( $answer['text'] ); ?>" />
					</td>
					<th class="lp-answer-check">
						<input type="hidden" name="learning_online_question[<?php echo $this->id; ?>][answer][value][]" value="<?php echo $value; ?>" />
						<input type="radio" name="learning_online_question[<?php echo $this->id; ?>][checked][]" <?php checked( $answer['is_true'] == 'yes', true ); ?> value="<?php echo $value; ?>" />
					</th>
					<?php if ( $this->type == 'single_choice' ): ?>
					<td class="lp-list-option-actions lp-remove-list-option">
						<i class="dashicons dashicons-trash"></i>
					</td>
					<?php endif;?>
					<td class="lp-list-option-actions lp-move-list-option open-hand">
						<i class="dashicons dashicons-sort"></i>
					</td>
				</tr>

				<?php do_action( 'learning_online_after_question_answer_option', $this ); ?>

			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<p class="question-bottom-actions">
		<?php
		$bottom_buttons = array();
		if( $this->type != 'true_or_false' ){
			array_splice( $bottom_buttons, 0, 0, sprintf(
					__( '<button class="button add-question-option-button add-question-option-button-%1$d" data-id="%1$d" type="button">%2$s</button>', 'learningonline' ),
					$this->id,
					__( 'Add Option', 'learningonline' )
				)
			);
		}
		$bottom_buttons = apply_filters(
			'learning_online_question_bottom_buttons',
			$bottom_buttons,
			$this
		);
		echo join( "\n", $bottom_buttons );
		?>
	</p>
</div>
<script type="text/javascript">
	jQuery(function ($) {
		LP.sortableQuestionAnswers($('#learning-online-question-<?php echo $this->id;?>'));
	})
</script>