<?php
require_once 'my_header1.php';

if (isset($_SESSION['user_id']))
{
	$pdo = myPDO::getInstance();
	$query = "SELECT user_id, firstname, lastname, username, email, profile_pic_url, theme FROM users
	WHERE user_id=:user_id
	";
	$sql = $pdo->prepare($query);
	$sql->execute(array(':user_id' => $_SESSION['user_id']));
	$count = $sql->rowCount();
	if ($count > 0)
	{
	  $result = $sql->fetchAll();
	  foreach($result as $row)
		$login = $row['username'];
		$url_image = $row['image_url'];
		$image_id = $row['image_id'];
		$profile_pic = $row['profile_pic_url'];
	}
?>
<header class="fixed_header navbar-inverse navbar-fixed-top">
  	<div class="container-fluid">
	  	<div class="navbar-header">
      		<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
		</div>
    	<div class="navbar-header">
      		<a class="navbar-brand" href="my_gallery_features.php">Gallery Feature</a>
    	</div>
		<ul class="nav navbar-nav">
			<li><a href="my_homepage.php">Home&nbsp;<i class="fa fa-home"></i></a></li>
			<li><a href="my_profile.php">
				<figure class="avatar image is-48x48">
					<img src='<?php echo $profile_pic?>' alt="Profil" draggable="false">
				</figure></a>
			</li>
			<li><a href="my_album.php">My Album&nbsp;<i class="fa fa-images"></i></a></li>
			<li><a href="my_settings1.php">Settings&nbsp;<i class="fa fa-cog fa-spin"></i></a></li>    
			<li><a href="my_signout.php">Sign Out&nbsp;<i class="fa fa-sign-out-alt"></i></a></li>
		</ul>
  	</div>
</header>
<?php
}
else
{ 
?>
<header class="navbar-inverse navbar-fixed-top">
  	<div class="container-fluid">
	  	<div class="navbar-header">
    		<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
		</div>
    	<div class="navbar-header">
    		<a class="navbar-brand" href='my_gallery_features.php'>Camagru</a>
    	</div>
	    <ul class="nav navbar-nav">
		    <li><a href="my_signin1.php">Sign in</a></li>
		    <li><a href="my_signup.php">Sign up</a></li>
        </ul>
  	</div>
</header>
<?php
}
?>
