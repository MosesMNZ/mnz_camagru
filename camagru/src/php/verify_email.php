<?php
 require_once  'classes.php';

if (!isset($_GET['log']) || !isset($_GET['key1']))
{
    header ('location: my_signup.php');
}
else
{
    $pdo = myPDO::getInstance();

    $login = htmlspecialchars($_GET['log']);
    $key1 = htmlspecialchars($_GET['key1']);
    $sql = $pdo->prepare("SELECT user_id FROM users WHERE username=:username AND user_activation_code=:user_activation_code AND user_email_status=:user_email_status");
    $sql->execute(
        array(
            ':username'             => $login,
            ':user_activation_code' => $key1,
            ':user_email_status'    => 'not verified'
        )
    );
    $sql->execute();
    $count_row = $sql->rowCount();

    if ($count_row > 0)
    {
        $sql = $pdo->prepare("UPDATE users SET user_email_status=:user_email_status, user_activation_code=:user_activation_code WHERE username=:username");
        $sql->execute(
            array(
                ':user_email_status'    => 'verified',
                ':user_activation_code' => '',
                ':username'             => $login
            )
        );
        header ('location: my_signin1.php');
    }
    else
    {
        header ('location: my_signup.php');
    }
}
?>