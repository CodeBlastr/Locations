<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
 		<legend><?php __('Admin Add Location'); ?></legend>
	<?php
		echo $this->Form->input('zip');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Locations', true), array('action' => 'index'));?></li>
	</ul>
</div>