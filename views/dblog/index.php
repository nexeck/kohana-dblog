<?php if (is_array($logs) && is_array($logs[0])): ?>
<table>
	<thead>
		<tr>
		<?php foreach (array_keys($logs[0]) as $key): ?>
			<th>
				<?php echo $model->fieldNameToLocalizedHeader($key); ?>
			</th>
		<?php endforeach; ?>
			<th><!-- details --></th>
		</tr>
	</thead>
	<tbody>
	<?php $rowNum = 0; foreach ($logs as &$log): // TODO filter the id, it should only be used for link generation ?>
		<tr class="<?php echo ($rowNum++ % 2) ? 'even' : 'odd'; ?>">
		<?php foreach ($log as &$value): ?>
			<td>
				<?php echo $value; ?>
			</td>
		<?php endforeach; ?>
			<td>
				<a href="<?php echo Request::instance()->uri().'/'.URL::query(array('log_id' => $log['id'])); ?>">
					<?php echo __('Details'); ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>