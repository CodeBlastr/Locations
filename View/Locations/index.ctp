<div class="locations index">
	<h2><?php echo __('Locations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('zip');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($locations as $location):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $location['Location']['id']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['zip']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['model']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['creator_id']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['modifier_id']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['created']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $location['Location']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $location['Location']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $location['Location']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $location['Location']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Location', true), array('action' => 'add')); ?></li>
	</ul>
</div>