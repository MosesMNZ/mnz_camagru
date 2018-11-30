<?php
require_once  'classes.php';
require_once  'session_start.php';

$title = 'Home Page';
$js_source = ['../js/my_webcam.js', '../js/do_publish_cancel.js', '../js/do_comment_like_delete.js'];

if (isset($_SESSION['user_id']))
{

 echo '<div id="alert"></div>';
  require_once 'my_header1.php';
?>
<section>
<div class="usearea_container">
  <div class="image_publish">
    <div class="row">
      <img  src="" id="photo" alt="photo">
    </div>
    <div class="row buttons-row">
      <div class="buttons col-md-12">
        <button type="submit" id="publishbutton" class="col-md-6  btn-success" onclick="publish_picture()">Publish</button>
        <button type="submit" id="deletebutton" class="col-md-6  btn-danger" onclick="cancel_picture()">Cancel</button>

      </div>
    </div>
  </div>
</div>
<div class="container">
<div class="col-md-6">

  <div class="row filters">
  <h3 style="font-family: brush script mt" class="center">First Step, Please choose a frame </h3>
  <div class="center">
          <img src="#" style="visibility:hidden"  draggable="false">
          <button type="button" class="btn btn-primary btn-radio active" onclick="select_frame(this.id)" id="1">No Frame</button>
          <input type="checkbox" name="src" class="hidden">
        </div>
    <form class="form-horizontal" role="form">
      <div class="row" >
      <div class="col-md-3 col-xs-6">
          <img src="../ressources/glass.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_frame(this.id)" id="2">Glass frame</button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../ressources/flower_frame.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_frame(this.id)" id="3">Flowers frame</button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../ressources/github.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_frame(this.id)" id="4">Github frame</button>
          <input type="checkbox" name="src" class="hidden">
          </div>
        <div class="col-md-3 col-xs-6">
          <img src="../ressources/water.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_frame(this.id)" id="5">Pure Water</button>
          <input type="checkbox" name="src" id="4" class="hidden">
        </div>


        
        
      </div>
    </form>
  </div>

  <div class="row">

    <div class="div_take_photo">
      <video id="video"></video>
      <canvas id="canvas"></canvas>
      <h3 style="font-family: brush script mt" class="center">Second Step, Please choose an Operation </h3>
      <div class="buttons col-md-12 center">
        <button id="startbutton" class="col-md-6 btn-primary">Camera</button>
        <div id="upload_photo" class="col-md-6 btn-primary label-file">
        <label for="file">Upload an image</label>
        <input type="file" class="input-file" name="pic" accept="image/png" id='file' src="" onchange="encode_picture(this)">
      </div>
    </div>
  </div>
</div>
</div>


    <div class="col-md-6 last_photos">
<?php
  $query = '
    SELECT image_url, image_id
  FROM users
  INNER JOIN gallery ON users.user_id = gallery.user_id
  WHERE gallery.user_id=:user_id
  ORDER BY gallery.date_time_photo DESC
  LIMIT 6';

  $query = $pdo->prepare($query);
  $query->execute(
    array(
      ':user_id' => $_SESSION['user_id']
    )

  );
  $count = $query->rowCount();
 
  if ($count > 0)
  {
    $result = $query->fetchAll();
      foreach ($result as $row)
      {
        ?>
        <div class="col-md-6 col-xs-6">
        <a  href="<?php echo $row['image_url']?>">
        <img class="thumbnails" src="<?php echo $row['image_url']?>" alt="">
        </a>
        <button class="delete_last_photo" onclick="delete_image(<?php echo  $row['image_id'];?>)">Delete</button>
        </div>
        <?php
      }

    
  }
    ?>
  </div>
  </div>
</section>

<?php
require_once 'my_footer.php';
}
else
  header ('location: my_signin1.php');
?>
