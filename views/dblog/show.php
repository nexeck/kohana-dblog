<table cellspacing="0" cellpadding="0">
	<tbody>
	<?php $row_num = 0; foreach ($log->as_array() as $key => $value): ?>
		<tr class="<?php echo ($row_num++ % 2) ? 'even' : 'odd'; ?>">
			<th>
				<?php echo $key; ?>
			</th>
			<td>
				<?php echo HTML::chars($value); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p>
	<?php echo HTML::anchor(Request::current()->referrer(), __('Back')); ?>
</p>