<?php echo Form::open(Request::current()->uri(), array('method' => 'GET')); ?>
	<p>
		<b>
			<?php echo __('Filter logs:'); ?>
		</b>
		<?php echo Form::label('log-filter-type', __('Type')); ?>
		<?php echo Form::select('log-filter[type]', $filter_values['type'], Arr::get($filters, 'type'), array('id' => 'log-filter-type')); ?>
		<?php echo Form::submit(NULL, NULL); ?>
	</p>
<?php echo Form::close(); ?>
<?php echo $pagination; ?>
<table cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>
				<?php echo __('Date/time'); ?>
			</th>
			<th>
				<?php echo __('Type'); ?>
			</th>
			<th>
				<?php echo __('Message'); ?>
			</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php $row_num = 0; foreach ($logs as & $log): ?>
		<tr class="<?php echo ($row_num++ % 2) ? 'even' : 'odd'; ?>">
			<td class="nowrap">

				<?php echo date('Y.m.d H:i:s', $log->created); ?>
			</td>
			<td>
				<?php echo $log->type; ?>
			</td>
			<td>
				<?php echo Text::limit_chars($log->message, 40, ' …', TRUE); ?>
			</td>
			<td>
				<a href="<?php echo URL::site(Request::current()->controller().'/show/'.$log->pk()); ?>">
					<?php echo __('Details'); ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $pagination; ?>