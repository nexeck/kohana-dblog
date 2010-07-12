<table>
	<tbody>
	<?php $rowNum = 0; foreach (array_keys($log->get_fields()) as $key): ?>
		<tr class="<?php echo ($rowNum++ % 2) ? 'even' : 'odd'; ?>">
			<th>
				<?php echo $log->field_name_to_localized_header($key); ?>
			</th>
			<td>
				<?php echo $log->get_formatted_field($key); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p>
	<a href="<?php echo Request::$referrer; ?>">
		<?php echo __('Back'); ?>
	</a>
</p>