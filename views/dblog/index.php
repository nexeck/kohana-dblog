<?php if (is_array($logs) && is_array($logs[0])): ?>
<table>
	<thead>
		<tr>
		<?php foreach (array_keys($logs[0]) as $key): ?>
			<th>
				<?php echo $model->fieldNameToLocalizedHeader($key); ?>
			</th>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
	<?php $rowNum = 0; foreach ($logs as &$log): ?>
		<tr class="<?php echo ($rowNum++ % 2) ? 'even' : 'odd'; ?>">
		<?php foreach ($log as $key => &$value): ?>
			<td>
				<?php echo $value; ?>
			</td>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>