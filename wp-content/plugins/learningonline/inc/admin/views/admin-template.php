<script type="text/html" id="tmpl-learning-online-search-items">
	<div class="modal-inner">
		<header>
			<input type="text" name="lp-search-term" placeholder="<# if(data.placeholder){#>{{data.placeholder}}<#}else{#><?php _e( 'Type here to search item', 'learningonline' ); ?><#}#>">
		</header>
		<article>
			<ul class="lp-list-items">
			</ul>
		</article>
		<footer>
			<input type="checkbox" class="chk-checkall" disabled="disabled" />
			<button class="lp-add-item button" disabled="disabled" data-text="<# if(data.addText){ #>{{data.addText}}<# }else{ #><?php _e( 'Add', 'learningonline' );?><# } #>">
				<# if(data.addText){ #>{{data.addText}}<# }else{ #><?php _e( 'Add', 'learningonline' );?><# } #>
			</button>
			<button class="lp-add-item close button" disabled="disabled" data-text="<# if(data.addAndCloseText){ #>{{data.addAndCloseText}}<# }else{ #><?php _e( 'Add and Close', 'learningonline' ); ?><# } #>">
				<# if(data.addAndCloseText){ #>
                                    {{data.addAndCloseText}}
                                <# }else{ #>
                                    <?php _e( 'Add and Close', 'learningonline' ); ?>
                                <# } #>
			</button>
			<button class="close-modal button" onclick="LP.MessageBox.hide();">
				<# if(data.closeText){ #>
                                    {{data.closeText}}
                                <# }else{ #>
                                    <?php _e( 'Close', 'learningonline' ); ?>
                                <# } #>
			</button>
		</footer>
	</div>
</script>
<script type="text/html" id="tmpl-learning-online-duplicate-course">
	<div id="learning-online-duplicate-course" class="modal-inner lp-modal-search">
		<header>
                        <h3><?php _e( 'Duplicate', 'learningonline' ); ?> <strong>{{ data.title }}</strong> <?php _e( 'course', 'learningonline' ); ?></h3>
		</header>
		<footer>
			<button class="lp-duplicate-course all-content button learning-online-tooltip" data-id="{{ data.id }}" data-nonce="<?php echo esc_attr( wp_create_nonce( 'lp-duplicate-course' ) ) ?>" data-text="<?php esc_attr_e( 'Duplicating ...', 'learningonline' ) ?>" data-content="<?php esc_attr_e( 'Duplicate course\'s curriculum', 'learningonline' ); ?>">
				<?php _e( 'All Content', 'learningonline' ); ?>
			</button>
			<button class="lp-duplicate-course button learning-online-tooltip" data-id="{{ data.id }}" data-nonce="<?php echo esc_attr( wp_create_nonce( 'lp-duplicate-course' ) ) ?>" data-text="<?php esc_attr_e( 'Duplicating ...', 'learningonline' ) ?>" data-content="<?php esc_attr_e( 'Duplicate course no curriculum', 'learningonline' ); ?>">
				<?php _e( 'No Content', 'learningonline' ); ?>
			</button>
			<button class="close-modal button" onclick="LP.MessageBox.hide();">
				<?php _e( 'Close', 'learningonline' ); ?>
			</button>
		</footer>
	</div>
</script>