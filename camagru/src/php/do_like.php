<?php
require_once 'session_start.php';
if ($_POST['imageId']) {
    if (isset($_SESSION['user_id']))
    {
        $pdo = myPDO::getInstance();
        if ($_POST['imageId'])
        {
            $query = "SELECT  likes, liked_id FROM gallery WHERE image_id=:image_id";
            $sql = $pdo->prepare($query);
            $sql->execute(
                array(
                    ':image_id' => $_POST['imageId']
                )
            );
            $count = $sql->rowCount();
            if ($count > 0)
            {
                $result = $sql->fetchAll();
                foreach($result as $row)
                {
                    $like = $row['likes'];
                    $liked_id1 = $row['liked_id'];
                    if ($liked_id1 != $_SESSION['user_id']) {
                        $like += 1;
                        $liked_id1 = $_SESSION['user_id'];
                    }
                    else {
                        $like -= 1;
                        $liked_id1 = -5;
                    }
                    $query = "UPDATE gallery SET likes=:likes, liked_id=:liked_id WHERE image_id=:image_id;";
                    $sql = $pdo->prepare($query);
                    $sql->execute(
                        array(
                            ':likes'     => $like,
                            ':liked_id'  => $liked_id1,
                            ':image_id'     => $_POST['imageId']
                        )
                    );
                }
            }
        }
    }
    else
    {
        $arr = ["error" => "You need to sign in or sign up before continuing."];
        echo json_encode($arr);
    }   
}
?>
