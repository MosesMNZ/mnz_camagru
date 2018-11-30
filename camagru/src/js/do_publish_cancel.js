function publish_picture() {
  my_a("image_publish", "publish=", "alert alert-success")
}

function cancel_picture() {
  my_a("usearea_container", "cancel=", "alert alert-danger")
}

function my_getEl(my_class, my_display1, my_display2) {
  document.getElementsByClassName(my_class)[0].style.display = my_display1;
  document.getElementsByClassName("div_take_photo")[0].style.display = my_display2;
  document.getElementsByClassName("last_photos")[0].style.display = my_display2;
  document.getElementsByClassName("filters")[0].style.display = my_display2;
}

function my_a(my_class1, publish_cancel, my_class2){
  var photo = document.getElementById("photo").src;
  photo = photo.replace("http://localhost:8080/camagru", "../..");
  my_getEl(my_class1, "block", "none");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/do_publish_cancel.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(publish_cancel + photo);
  xhr.onreadystatechange = function(event) {
    if (this.readyState === 4) {
      if (this.status === 200) {
        var div = document.createElement("div");
        var p = document.createElement("p");
        var text2 = document.createTextNode(JSON.parse(this.responseText).success);
        div.className = my_class2;
        p.className = "p_danger";
        p.appendChild(text2);
        div.appendChild(p);
        var alert = document.getElementById("alert");
        alert.appendChild(div);
        var my_p = document.getElementsByClassName("p_danger");
        if (my_p[0]) {
          setTimeout(function() {
            var div = my_p[0].parentElement;
            div.remove();
          }, 2000);
        }
        my_getEl("usearea_container", "none", "block");
        if (close[0]) {
          setTimeout(function() {
            var div = close[0].parentElement;
            div.remove();
          }, 2000);
        }
        setTimeout(function(){
          window.location.reload(1);
       }, 2000);
      }
    }
  };
}