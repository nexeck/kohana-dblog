<?php if (is_array($logs) && count($logs) > 0): ?>
<?php echo $pagination; ?>
<table>
	<thead>
		<tr>
			<th>
				<a href="<?php echo URL::site(Request::instance()->uri()).'/'.URL::query(array('order_by' => 'tstamp', 'order_dir' => $orders->tstamp)); ?>">
					<?php echo __('Date/time'); ?>
				</a>
			</th>
			<th>
				<a href="<?php echo URL::site(Request::instance()->uri()).'/'.URL::query(array('order_by' => 'type', 'order_dir' => $orders->type)); ?>">
					<?php echo __('Type'); ?>
				</a>
			</th>
			<th>
				<?php echo __('Message'); ?>
			</th>
			<th><!-- details --></th>
		</tr>
	</thead>
	<tbody>
	<?php $rowNum = 0; foreach ($logs as &$log): ?>
		<tr class="<?php echo ($rowNum++ % 2) ? 'even' : 'odd'; ?>">
			<td class="nowrap">
				<?php echo $log->get_formatted_field('tstamp'); ?>
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