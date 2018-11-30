<?php
require_once 'session_start.php';

if (isset($_POST['publish']))
{
    $file = htmlspecialchars($_POST['publish']);
    $time = time();
    $pdo = myPDO::getInstance();
    $query = "
        INSERT INTO `gallery` (`image_url`, `user_id`, `date_time_photo`, likes, liked_id, comments)
        VALUES (:image_url, :user_id, :date_time_photo, :likes, :liked_id, :comments)
        ";
    $sql = $pdo->prepare($query);
    $sql->execute(
        array(
            ':image_url'       => $file,
            ':user_id'         => $_SESSION["user_id"],
            ':date_time_photo' => $time,
            ':likes'           => 0,
            ':liked_id'        => 999,
            ':comments'        => 0
            )
        );
    $count_image = $sql->rowCount();
    if ($count_image > 0)
    {
        $arr = ["success" => "The photo has been saved successfully."];
        echo json_encode($arr);
    }
}
else if (isset($_POST['cancel']))
{
    $file = $_POST['cancel'];
    if (file_exists($file))
    {
        unlink($file);
        $arr = ["success" => "You did not publish the photo."];
        echo json_encode($arr);
    }      
}