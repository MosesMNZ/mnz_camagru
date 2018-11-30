<?php
require_once 'session_start.php';
if ($_POST['imageId']) {
    if (isset($_SESSION['user_id']))
    {
        $pdo = myPDO::getInstance();
        
            $query = "
                SELECT image_id, user_id, image_url
                FROM gallery
                WHERE image_id=:image_id AND user_id=:user_id
                ";
            $sql = $pdo->prepare($query);
            $sql->execute(
                array(
                    ':image_id' => htmlspecialchars($_POST['imageId']),
                    ':user_id' => $_SESSION['user_id']
                    )
                );
            $count = $sql->rowCount();
            if ($count > 0)
            {
                $result = $sql->fetchAll();
                foreach($result as $row)
                {
                    $image_id = $row['image_id'];
                    $user_id = $row['user_id'];
                    $img_url = $row['image_url'];
                    $query = "
            
                    DELETE
                    FROM gallery
                    WHERE image_id=:image_id
                    ";
                $sql = $pdo->prepare($query);
                $sql->execute(
                    array(
                        ':image_id' => $image_id,
                        )
                    );

                    $file = str_replace("http://localhost:8080/", "../../", $img_url);
                    if (file_exists($file))
                        unlink($file);
                }
                $arr = ["success" => "your photo has been successfully deleted"];
                echo json_encode($arr);
            }
            else
            {
                $arr = ["error" => "Oooops!!! You are not allowed to delete this picture!"];
                echo json_encode($arr);
            }

    }
    else
    {
        $arr = ["error" => "Please sign in or sign up first"];
        echo json_encode($arr);
    }
    
}
?>
