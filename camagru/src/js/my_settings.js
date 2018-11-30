function upload_profile_pic(element) {
    var filesSelected = element.files;
    if (filesSelected.length > 0) {
      var fileToLoad = filesSelected[0];
      var fileReader = new FileReader();
      fileReader.onload = function(fileLoadedEvent) {
        var srcData = fileLoadedEvent.target.result;
        if (srcData.match(/data:image\/png;base64/))
        {
            var data = srcData.replace("data:image/png;base64,", "");
            var type = "png";
        }
        else if (srcData.match(/data:image\/jpg;base64/) || srcData.match(/data:image\/jpeg;base64/))
        {
            var data = srcData.replace("data:image/jpeg;base64,", "");
            var type = "jpeg";
        }
        if (data)
        {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../php/do_upload_profile_pic.php", true);
            xhr.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            );
            xhr.send("base64=" + data + "&type=" + type);
            xhr.onreadystatechange = function(event) {
              if (this.readyState === 4) {
                if (this.status === 200) {
                  if (this.responseText)
                  {
                    var photo = document.getElementById('profile_pic_settings');
                    photo.setAttribute("src", JSON.parse(this.responseText).file);
                  }
                  else
                    my_function2("Ooops!!! Wrong Picture format! Please choose a png format.");
                }
              }
            };
        }
        else
          my_function2("Ooops!!! Wrong Picture format! Please choose a png format.");
      };
      if (fileToLoad) fileReader.readAsDataURL(fileToLoad);
    }
  }

  function change_theme(id)
  {
    var sel = document.getElementById(id);
    for ( var i = 0, len = sel.options.length; i < len; i++ ) {
      if (sel.options[i].selected == true)
      {
        var opt = sel.options[i];
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/theme.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xhr.send("theme=" + opt.text);
        xhr.onreadystatechange = function(event) {
          if (this.readyState === 4) {
            if (this.status === 200) {
              var text_node = 'You have successfully changed the theme';
              var get_doc = setTimeout(function(){window.location.reload(1);}, 2000);
              my_function2(text_node, get_doc);
            }
          }
        };
      }
    }       
  }

  function notify() {
    var checkBox = document.getElementById("myCheck");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/enable_notifications.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    if (checkBox.checked == true){
        xhr.send("checked=yes");
    } else {
        xhr.send("checked=no");
    }
    xhr.onreadystatechange = function(event) {
      if (this.readyState === 4) {
        if (this.status === 200) {
          if ((this.responseText))
          {
            var div = document.createElement("div");
            var p = document.createElement("p");
            var text2 = document.createTextNode(JSON.parse(this.responseText).success);
            div.className = "alert alert-success";
            p.className = "p_danger";
            p.appendChild(text2);
            div.appendChild(p);
            var alert = document.getElementById("alert");
            alert.appendChild(div);
            var p_success = document.getElementsByClassName("p_danger");
            if (p_success[0]) {
              setTimeout(function() {
                var div = p_success[0].parentElement;
                div.remove();
              }, 2000);
            }
          }
        }
      }
    };
}