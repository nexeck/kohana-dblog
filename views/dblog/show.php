<table>
	<tbody>
	<?php $rowNum = 0; foreach (array_keys($log->getFields()) as $key): ?>
		<tr class="<?php echo ($rowNum++ % 2) ? 'even' : 'odd'; ?>">
			<th>
				<?php echo $log->fieldNameToLocalizedHeader($key); ?>
			</th>
			<td>
				<?php echo $log->getFormattedField($key); ?>
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