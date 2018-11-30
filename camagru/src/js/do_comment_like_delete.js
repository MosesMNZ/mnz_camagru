var count = 0;
function show_comment(id){
  count += 1;
  if (count % 2 == 1){ 
    var p = document.getElementsByClassName('display_none');
    for (var i = 0; i < p.length; i++)
      p[i].style.display = "block";
  }
  else{
    var p = document.getElementsByClassName('display_none');
    for (var i = 0; i < p.length; i++)
      p[i].style.display = "none";
  }
}

function add_comment(id){
  var value = document.getElementsByClassName(id)[0].value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/do_comments.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("imageId=" + id + "&value=" + value);
  xhr.onreadystatechange = function(event) {
    if (this.readyState === 4) {
      if (this.status === 200) {
        if (JSON.parse(this.responseText).error) {
          var text_node = JSON.parse(this.responseText).error;
          var get_doc = document.getElementsByClassName(id)[0].value = "";
          my_function2(text_node, get_doc);
        }
        else{
          get_doc;
          location.reload();
        }
      }
    }
  };
}

function like_photo(id){
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/do_like.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("imageId=" + id);
  xhr.onreadystatechange = function(event) {
    if (this.readyState === 4) {
      if (this.status === 200) {
        if ((this.responseText)) JSON.parse(this.responseText).error
        else
          location.reload();
      }
    }
  };
}

function delete_image(id)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/do_delete_image.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("imageId=" + id);
    xhr.onreadystatechange = function(event) {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          if ((this.responseText))
          {
            var div = document.createElement("div");
            var p = document.createElement("p");
            var alert = document.getElementById("alert");
            if (JSON.parse(this.responseText).error)
            {
              var text2 = document.createTextNode(JSON.parse(this.responseText).error);
              div.className = "alert alert-danger";
              p.className = "p_danger";
              p.appendChild(text2);
              div.appendChild(p);
              alert.appendChild(div);
              var p_success = document.getElementsByClassName("p_danger");
            }
            else if (JSON.parse(this.responseText).success)
            {
              var text2 = document.createTextNode(JSON.parse(this.responseText).success);
              div.className = "alert alert-success";
              p.className = "p_danger";
              p.appendChild(text2);
              div.appendChild(p);
              alert.appendChild(div);
              var p_success = document.getElementsByClassName("p_danger");
            }
            
            if (p_success[0]) {
              setTimeout(function() {
                var div = p_success[0].parentElement;
                div.remove();
              }, 2000);
            }
            setTimeout(function(){
              window.location.reload(1);
           }, 2000);
          }
        }
      }
    };
}


