<html>
	<head>
		<title>
			<?php
			if(isset($title) && !empty($title))
    	    	echo $title; 
    		else
    	    	echo "Camagru"; 
			?>
		</title>
		<?php
		if (isset($_SESSION['user_id']))
		{
			if (isset($_SESSION['theme']))
			{
				if ($_SESSION['theme'] == 'Default')
					echo '<link rel="stylesheet" type="text/css" href="../css/default.css" id="css2"/>';
				else if ($_SESSION['theme'] == 'Mangeta')
					echo '<link rel="stylesheet" type="text/css" href="../css/mangeta.css" id="css3"/>';
			}
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo "../css/media1.css";?>" id="css1"/>
		<?php
		}
		else
		{
		?>
			<link rel="stylesheet" type="text/css" href="<?php echo "../css/media1.css";?>" id="css1"/>
			<link rel="stylesheet" type="text/css" href="<?php echo "../css/default.css";?>" id="css2"/>
		<?php
		}
		?>
    	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.0/css/bulma.min.css"/>
    	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
	</head>
	<body>
		<?php
		require_once 'my_header2.php';
		?>
	</body>
</html>