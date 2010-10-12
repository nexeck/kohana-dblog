<?php if (is_array($logs) && count($logs) > 0): ?>
<?php echo $pagination; ?>
<table>
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
				<?php echo $log->tstamp; ?>
			</td>
			<td>
				<?php echo $log->type; ?>
			</td>
			<td>
				<?php echo Text::limit_chars($log->message, 40, ' …', TRUE); ?>
			</td>
			<td>
				<a href="<?php echo URL::site(Request::instance()->uri()).'/'.URL::query(array('log_id' => $log->pk())); ?>">
					<?php echo __('Details'); ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $pagination; ?>
<?php endif; ?>