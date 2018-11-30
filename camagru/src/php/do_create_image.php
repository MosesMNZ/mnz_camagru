<?php
require_once 'session_start.php';

    if (isset($_POST['base64']) && isset($_POST['src']))
    {
         if (!is_dir('../../gallery_storage'))
         {
            mkdir('../../gallery_storage');
            if (!is_dir('../../gallery_storage/'.$login))
            mkdir('../../gallery_storage/'.$login);
         }
           
         else
         {
         if (!is_dir('../../gallery_storage/'.$login))
             mkdir('../../gallery_storage/'.$login);
         }
       
        $name_img = md5(rand());
        $data = str_replace(" ", "+", htmlspecialchars($_POST['base64']));
        $plainText = base64_decode($data);
        $filename = '../../gallery_storage/'.$login.'/'.$name_img.'.png';
        file_put_contents($filename, $plainText);
        if (exif_imagetype($filename) == 3)
        {
            $filter = htmlspecialchars($_POST['src']);
            $source = imagecreatefrompng($filter);
           $destination = imagecreatefrompng($filename);
           
            $source_width = imagesx($source);
            $source_height = imagesy($source);
            
            $dest_width = imagesx($destination);
            $dest_height = imagesy($destination);
            $destination_x = $dest_width / 2 - $source_width / 2;
            $destination_y =  $dest_height / 2 - $source_height / 2;
            imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $source_width, $source_height); 
            
            imagepng($destination, $filename);
            $arr = ["file" => $filename];
            echo json_encode($arr);
        }
    }
?>