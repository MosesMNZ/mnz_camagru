<?php

require_once  'classes.php';

$title = 'Settings';
$js_source = ['../js/my_settings.js'];
session_start();


if (isset($_SESSION['user_id']))
{
    echo '<div id="alert"></div>';
  $pdo = myPDO::getInstance();
  $query = "
      SELECT user_id, firstname, lastname, username, notif_comment, profile_pic_url, theme FROM users
      WHERE user_id=:user_id
      ";
  $sql = $pdo->prepare($query);
  $sql->execute(
          array(
              ':user_id' => $_SESSION['user_id']
              )
          );
  $count = $sql->rowCount();
  if ($count > 0)
  {
    $result = $sql->fetchAll();
    foreach($result as $row)
    {
      $fname = $row['firstname'];
      $lname = $row['lastname'];
      $login = $row['username'];
      $notif = $row['notif_comment'];
      $profile_pic_url = $row['profile_pic_url'];
      $theme = $row['theme'];
    }
    if (isset($_POST['submit']) && $_POST['submit'] == "OK")
    {
        $pdo = myPDO::getInstance();




        $error = [];

        $values = [
            'firstname' => htmlspecialchars($_POST['firstname']),
            'lastname' => htmlspecialchars($_POST['lastname']),
            'username'       => $_POST['username'],
            'email'          => $_POST['email'],
            'old_passwd'     => $_POST['old_passwd'],
            'new_passwd'     => $_POST['new_passwd'],
            'confnew_passwd' => $_POST['confnew_passwd']

        ];
        $query = "SELECT firstname, lastname, username, email FROM users";
        $sql = $pdo->prepare($query);
        $sql->execute();
        $count = $sql->rowCount();
        if ($count > 0)
        {
            $result = $sql->fetchAll();
            $firstname = [];
            $lastname = [];
            $username = [];
            $email = [];
            foreach($result as $row)
            {
                array_push($firstname, $row['firstname']);
                array_push($lastname, $row['lastname']);
                array_push($username, $row['username']);
                array_push($email, $row['email']);
            }
        }

        if (!empty($values['firstname']))
        {
            if (!preg_match('/^[a-zA-Z]+$/', $values['firstname']) || empty($values['firstname']))
                $error['firstname'] = "Invalid first name! Your first name must contain only upper and lower case letters!";
        }
        if (!empty($values['lastname']))
        {
            if (!preg_match('/^[a-zA-Z]+$/', $values['lastname']) || empty($values['lastname']))
                $error['lastname'] = "Invalid last name! Your last name must contain only upper and lower case letters!";
        }
        
        if (!empty($values['username']))
        {
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $values['username']))
                $error['username'] = "Your username can only contain letters, numbers or '_'!";
            if (in_array($values['username'], $username))
                $error['username'] = "This username exist. Please choose another username!";

        }
            

        if (!empty($values['email']))
        {
            if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL))
                $error['email'] = "Invalid email!";
            if (in_array($values['email'], $email))
                $error['email'] = "This email exist. Please choose another email!";
        }
            

        if (!empty($values['new_passwd']))
        {
            if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/', $values['new_passwd']))
                $error['passwd'] = "Wrong new password! Your password must contain at least 1 number, 1 lowercase and 1 upper case letter";
            if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/', $values['old_passwd']) || empty($values['old_passwd']))
                $error['passwd'] = "Wrong old password. Try again!";
            if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/', $values['confnew_passwd']) || empty($values['confnew_passwd']))
                $error['passwd'] = "Wrong confirm password! Your password must contain at least 1 number, 1 lowercase and 1 upper case letter";
            if ($values['new_passwd'] != $values['confnew_passwd'])
                    $error['passwd'] = "New password and confirm password are different. Try again!";

        }

        if (!empty($values['confnew_passwd']) && empty($values['new_passwd']))
                $error['passwd'] = "Empty new password. Try again!";
        
        if (empty($error))
        {
            $query = "
            SELECT passwd FROM users
            WHERE user_id=:user_id
        ";

            $sql = $pdo->prepare($query);
            $sql->execute(
            array(
                ':user_id' => $_SESSION['user_id']
                )
            );
            $count = $sql->rowCount();
            if ($count > 0)
            {
                $valid = [];
                $result = $sql->fetchAll();
                if (!empty($values['firstname']))
                    $valid['firstname'] = $values['firstname'];
                if (!empty($values['lastname']))
                    $valid['lastname'] = $values['lastname'];
                if (!empty($values['username']))
                    $valid['username'] = $values['username'];
                if (!empty($values['email']))
                    $valid['email'] = $values['email'];
                foreach($result as $row)
                {
                    if (!empty('new_passwd'))
                    {
                        $encrypted_passwd = hash('whirlpool', $values['old_passwd']);
                        if($encrypted_passwd == $row['passwd'])
                        {
                            if($values['new_passwd'] == $values['confnew_passwd'])
                            {
                                $encrypted_passwd = hash('whirlpool', $values['new_passwd']);
                                $valid['passwd'] = $encrypted_passwd;
                            }
                            else
                            {
                                $error['passwd'] = "Please verify confirm password";
                            }
                        }
                        else
                        {
                            $error['passwd'] = "Wrong old password";
                        }
                    }
                }
                if (!empty($valid))
                {
                    foreach($valid as $key => $value)
                    {
                         $query = "
                           UPDATE users SET $key=:value WHERE user_id=:user_id;
                         ";
                         $sql = $pdo->prepare($query);
                         $sql->execute(
                             array(
                                 ':value' => $value,
                                 ':user_id'     => $_SESSION['user_id']
                                 )
                             );
                         $count = $sql->rowCount();
                    }
                    ?>
                        <div class="alert alert-success">
                            <a class="close" aria-label="close">&times;</a>
                            <p>The user has successfully changed</p>
                        </div>
                    <?php
                }
            }
            else
            {
                $error['wrong_user'] = "Wrong User";
            }
        }
        else
        {
            ?>
            <div class="alert alert-danger">
            <a class="close" aria-label="close">&times;</a>
            <?php 
                foreach($error as $value)
                    echo "Error: " . $value . "<br>";
            ?>
            </div>
            <?php
        }
    }
   
  }
  require_once 'my_header1.php';
?>
<div style="margin: -2% 10% 1% 10%" class="settings row">
    <div class="profile image settings">
        <label for="file"><img src='<?php echo $profile_pic_url?>' alt="" id="profile_pic_settings" draggable="false"></label>
        <input type="file" class="input-file" name="pic" accept="image/*" id='file' src="" onchange="upload_profile_pic(this)" onclick="this.value=null;">
    </div>
</div>

<section style="margin: -2.5% 10% 1% 10%" class="sectionsettings">
    <div class="row" style="width: 125%">
        <div class="container">
            <div class="row divform">
                <div class="user_prefeferences col-md-6" style="float: right">
                    <p class="center"><i class="fa fa-wrench fa-spin settings"></i>Preference Settings</p>
                    <div class="row notif_row">
                        <i class="fa fa-bell"></i>
                        <form class="notif_form">
                            <label class="switch">
                                <input type="checkbox"  id="myCheck" onclick="notify()" <?php if ($notif == 'yes') echo 'checked';?>>
                                <span class="slider round"></span>
                            </label>
                        </form>
                    </div>
                    <div class="row notif_row">
                        Theme
                        <select id="selectTheme" onchange="change_theme(this.id)" name="test">
                            <option value="1" id="defaultTheme"  <?php if ($theme == 'Default') echo "selected";?>>Default</option>
                            <option value="2" id="mangetaTheme" <?php if ($theme == 'Mangeta') echo "selected";?>>Mangeta</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="width: 75%">
        <div class="container">
            <div class="row divform">
                <div class="user_info col-md-6">
                    <p class="center"><i class="fa fa-user-circle fa-spin settings"></i>General Account Settings</p>
                        <form method="POST"  id="registerform" >
                            <input type="text" name="firstname" value="" placeholder="New Firstname">
                            <input type="text" name="lastname" value="" placeholder="New Lastname">
                            <input type="text" name="username" value="" placeholder="New username">
                            <input type="email" name="email" value="" placeholder="New Email address">
                            <input type="password" name="old_passwd" value="" placeholder="Old Password">
                            <input type="password" name="new_passwd" value="" placeholder="New Password">
                            <input type="password" name="confnew_passwd" value="" placeholder="Confirm New Password">
                            <button class="settings submit btn"type="submit" name="submit" value="OK">Save</button>
                            <button class="settings reset btn" type="reset" name="reset" value="Reset">Cancel</button>
                        </form>
                    </div>

            </div>
        </div>
    </div>
</section>

<?php
require_once 'my_footer.php';
}
else
  header ('location: my_signin1.php');
?>
