<?php

include("./config.php");

$stmt = $con->prepare("SELECT `v_id`, `v_date`, `v_status` FROM `visits` ORDER BY `v_id` DESC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<br><br>
<center>
<table border="2" cellpadding="4">
	<tr>
		<td>ID</td>
		<td>DATE</td>
		<td>COUNT</td>
	</tr>
	<?php
	foreach($rows as $row)
	{
	?>
		<tr>
			<td><?php echo $row["v_id"]; ?></td>
			<td><?php echo $row["v_date"]; ?></td>
			<td><?php echo $row["v_status"]; ?></td>
		</tr>
	<?php
	}
	?>
</table>
</center>