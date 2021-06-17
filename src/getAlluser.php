<?php 
	require_once ('auth/auth.database.php');
	require_once ('class/getUserClass.php');

	$userClass = new getUserClass();
	$dataAll = $userClass->getUserAll();

	// $dataAll = $userClass->fetchMe("address");

	?>
	<table border="1" width="80%">
		<tr>
			<td>userid</td>
			<td>username</td>
			<td>password</td>
			<td>firstname</td>
			<td>lastname</td>
			<td>mail</td>
			<td>DOB</td>
			<td>phone</td>
			<td>picture</td>
		</tr>
	
	<?php
	foreach ($dataAll as $data) {
		?>
			<tr>
				<td><?php echo $data['UserID'];?></td>
				<td><?php echo $data['UserName'];?></td>
				<td><?php echo $data['Password'];?></td>
				<td><?php echo $data['FirstName'];?></td>
				<td><?php echo $data['LastName'];?></td>
				<td><?php echo $data['Mail'];?></td>
				<td><?php echo $data['DOB'];?></td>
				<td><?php echo $data['Phone'];?></td>
				<td><img src="images/<?php echo $data['Picture'];?>" width="150"></td>
			</tr>
		<?php
	}
?>
	</table>