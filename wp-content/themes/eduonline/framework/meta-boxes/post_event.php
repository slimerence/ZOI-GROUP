<div id="jws_theme_event_metabox" class='tb-event-metabox'>
	<?php
	$this->text('event_day',
			'Event day',
			'',
			__('Enter event day of this event. Ex: 2017/10/20 12:34:56.','eduonline')
	);
	?>
	
	<?php
	$this->text('start_time',
			'Start at',
			'',
			__('to','eduonline')
	);
	?>
	
	<?php
	$this->text('end_time',
			'',
			'',
			__('Enter start to end time of this event.','eduonline')
	);
	?>
	<?php
	$this->text('address',
			'Address',
			'',
			__('Enter address of this event.','eduonline')
	);
	?>
	<?php
	$this->text('phone',
			'Phone number',
			'',
			__('Enter phone number of this even.','eduonline')
	);
	?>

	<?php
	$this->textarea('event_social',
			'Socials',
			'',
			__('Enter social of this even.','eduonline')
	);
	?>
</div>