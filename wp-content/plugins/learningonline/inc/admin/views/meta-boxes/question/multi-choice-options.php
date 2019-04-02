<?php
$option_headings = array(
	'answer_text'    => __( 'Answer Text', 'learningonline' ),
	'answer_correct' => __( 'Is Correct?', 'learningonline' ),
	'actions'        => '',
	'sort'           => ''
);

$option_headings = apply_filters( 'learning-online/question/multi-choices/admin-option-headings', $option_headings, $this->id );
?>

<div class="learning-online-question" id="learning-online-question-<?php echo $this->id; ?>" data-type="multi-choice" data-id="<?php echo $this->id; ?>">

	<p class="question-bottom-actions">
		<?php
		$top_buttons = apply_filters(
			'learning_online_question_top_buttons',
			array(
				'change_type' => learning_online_dropdown_question_types( array( 'echo' => false, 'id' => 'learning-online-dropdown-question-types-' . $this->id, 'selected' => $this->type ) )
			),
			$this
		);
		echo join( "\n", $top_buttons );
		?>
	</p>
	<table class="lp-sortable lp-list-options" id="learning-online-list-options-<?php echo $this->id; ?>">
		<thead>
		<tr>
			<?php foreach ( $option_headings as $key => $text ) { ?>
				<?php
				$classes = apply_filters( 'learning-online/question/multi-choices/admin-option-column-heading-class', array( 'column-heading', 'column-heading-' . $key ) );
				?>
				<th class="<?php echo join( ' ', $classes ); ?>">
					<?php do_action( 'learning-online/question/multi-choices/admin-option-column-heading-before-title', $key, $this->id ); ?>
					<?php echo apply_filters( 'learning-online/question/multi-choices/admin-option-column-heading-title', $text ); ?>
					<?php do_action( 'learning-online/question/multi-choices/admin-option-column-heading-after-title', $key, $this->id ); ?>
				</th>
			<?php } ?>
		</tr>
		<!--
		<th><?php _e( 'Answer Text', 'learningonline' ); ?></th>
		<th><?php _e( 'Is Correct?', 'learningonline' ); ?></th>
		<th width="20"></th>
		<th width="20"></th>
		-->
		</thead>
		<tbody>

		<?php $answers = $this->answers;
		if ( $answers ): ?>
			<?php foreach ( $answers as $answer ): ?>
				<?php
				$value = $this->_get_option_value( $answer['value'] );
				?>

				<?php do_action( 'learning_online_before_question_answer_option', $this ); ?>

				<tr class="lp-list-option lp-list-option-<?php echo $value; ?>" data-id="<?php echo $value; ?>">
					<?php foreach ( $option_headings as $heading => $title ) { ?>
						<?php
						$classes = array( 'column-content', 'column-content-' . $heading );
						ob_start();
						switch ( $heading ) {
							case 'answer_text':
								?>
								<input class="lp-answer-text no-submit key-nav" type="text" name="learning_online_question[<?php echo $this->id; ?>][answer][text][]" value="<?php echo esc_attr( $answer['text'] ); ?>" />
								<?php
								break;
							case 'answer_correct':
								$classes[] = 'lp-answer-check';
								?>
								<input type="hidden" name="learning_online_question[<?php echo $this->id; ?>][answer][value][]" value="<?php echo $value; ?>" />
								<input type="checkbox" name="learning_online_question[<?php echo $this->id; ?>][checked][]" <?php checked( $answer['is_true'] == 'yes', true ); ?> value="<?php echo $value; ?>" />
								<?php
								break;
							case 'actions':
								$classes[] = 'lp-list-option-actions lp-remove-list-option';
								?>
								<i class="dashicons dashicons-trash"></i>
								<?php
								break;
							case 'sort':
								$classes[] = 'lp-list-option-actions lp-move-list-option open-hand';
								?>
								<i class="dashicons dashicons-sort"></i>
								<?php
								break;

						}
						$classes = apply_filters( 'learning-online/question/multi-choices/admin-option-column-class', $classes, $heading, $answer, $this->id );
						$classes = array_filter( $classes );
						$classes = array_unique( $classes );
						?>
						<?php do_action( 'learning-online/question/multi-choices/admin-option-column-' . $heading . '-content', $answer, $this->id ); ?>
						<?php do_action( 'learning-online/question/multi-choices/admin-option-columns-content', $heading, $answer, $this->id ); ?>
						<?php $html = ob_get_clean(); ?>
						<th class="<?php echo join( ' ', $classes ); ?>">
							<?php echo $html; ?>
						</th>
					<?php } ?>
					<!--
					<td>
						<input class="lp-answer-text no-submit key-nav" type="text" name="learning_online_question[<?php echo $this->id; ?>][answer][text][]" value="<?php echo esc_attr( $answer['text'] ); ?>" />
					</td>
					<th class="lp-answer-check">
						<input type="hidden" name="learning_online_question[<?php echo $this->id; ?>][answer][value][]" value="<?php echo $value; ?>" />
						<input type="checkbox" name="learning_online_question[<?php echo $this->id; ?>][checked][]" <?php checked( $answer['is_true'] == 'yes', true ); ?> value="<?php echo $value; ?>" />
					</th>
					<td class="lp-list-option-actions lp-remove-list-option">
						<i class="dashicons dashicons-trash"></i>
					</td>
					<td class="lp-list-option-actions lp-move-list-option open-hand">
						<i class="dashicons dashicons-sort"></i>
					</td>
					-->
				</tr>

				<?php do_action( 'learning_online_after_question_answer_option', $this ); ?>

			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<p class="question-bottom-actions">
		<?php
		$bottom_buttons = apply_filters(
			'learning_online_question_bottom_buttons',
			array(
				'add_option' => sprintf(
					__( '<button class="button add-question-option-button add-question-option-button-%1$d" data-id="%1$d" type="button">%2$s</button>', 'learningonline' ),
					$this->id,
					__( 'Add Option', 'learningonline' )
				)
			),
			$this
		);
		echo join( "\n", $bottom_buttons );
		?>
	</p>
</div>
<script type="text/javascript">
	jQuery(function ($) {
		LP.sortableQuestionAnswers($('#learning-online-question-<?php echo $this->id;?>'));
	});
</script>