<div id="jws_theme_classes_metabox" class='tb-classes-metabox'>
	<?php
	$this->input_date('date',
			'Start Date',
			'',
			__('Enter start date for this course post.','aqua')
	);
	?>
	<?php
	$this->text('classes_size',
			'Classes size',
			'',
			__('Enter class size for this classes post.','prechool')
	);
	?>
	
	<?php
	$this->text('member_hours',
			'Member per hours',
			'',
			__('Enter member per hours for this classes post.','prechool')
	);
	?>
	
	<?php
	$this->text('year_olds',
			'Year olds',
			'',
			__('Enter year olds for this classes post.','prechool')
	);
	?>

	<?php
	$this->text('start_date',
			'Start date',
			'',
			__('Enter start date for this classes post.','prechool')
	);
	?>

	<?php
	$this->text('class_duration',
			'Class Duration',
			'',
			__('Enter class duration for this classes post.','prechool')
	);
	?>

	<?php
	$this->text('transportation',
			'Transportation',
			'',
			__('Enter transportation for this classes post.','prechool')
	);
	?>

	<?php
	$this->text('class_staff',
			'Class staff',
			'',
			__('Enter class staff for this classes post.','prechool')
	);
	?>
	<?php
	$this->text('class_price',
			'Class price per day',
			'',
			__('Enter price per day for this classes post.','prechool')
	);
	?>
	<?php
	$this->uploadM('post_preview_image',
			'Preview Images',
			__('Click the "Browse" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted image.','prechool')
	);
	
	?>
</div>