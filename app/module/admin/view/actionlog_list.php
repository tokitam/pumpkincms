<table class="table table-striped table-hover">
<tbody>
<tr><th>user</th><th>TYPE</th><th>IP_ADDRESS</th><th>Date</th><th>desc</th><th>USER AGENT</th></tr>
<?php foreach ($this->list as $actionlog) : ?>
<tr>
	<td><?php echo $actionlog['user_id'] ?></td>
	<td><?php echo $actionlog['type'] ?></td>
	<td><?php echo long2ip($actionlog['ip_address']) ?></td>
	<td><?php echo date('Y-m-d H:i', $actionlog['reg_time']) ?></td>
	<td><?php echo htmlspecialchars($actionlog['desc']) ?></td>	
	<td><a rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="<?php echo htmlspecialchars($actionlog['user_agent']) ?>"><?php echo htmlspecialchars(PC_Util::mb_truncate($actionlog['user_agent'], 40)) ?></a></td>
</tr>
<?php endforeach ; ?>
</tbody>
</table>
