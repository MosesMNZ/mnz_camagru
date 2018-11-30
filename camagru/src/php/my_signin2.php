<?php
require_once 'my_header1.php';
?>

<section class="section login center">

    <img src="../ressources/photoshare.png" width=500 height=300 draggable="false">
    <div class="container">

        <div>
            <div class=" divform">
            <form  method="POST" id="loginform">
                <h1 style="font-family: brush script mt" class="cam center">Camagru</h1>
                <input type="text" name="userlogin" value="" placeholder="Username or email" required>
                <input type="password" name="usrpasswd" value="" placeholder="Password" required>
                <button type="submit">Sign in</button>
            </form>
            <p class="center"><a href="reset_passwd.php">Forgot password?</a></p>
            </div>
            <div class=" divform1">
                 <p class="center">Don't have an account? <a href="my_signup.php" class="loginlink">Sign up</a></p>
            </div> 
        </div>
    </div>

</section>

<?php
    require_once 'my_footer.php';
?>
