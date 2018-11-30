postData = [];

function select_frame(id) {
  el = document.getElementsByClassName("active");
  el[0].parentNode.children[0].style.opacity = 1;
  el[0].className = el[0].className.replace(" active", "");
  for (var i = 1; i <= 5; i++) {
    el = document.getElementById(i);
    el.parentNode.children[2].checked = false;
  }
  el = document.getElementById(id);
  el.className += " active";
  el.parentNode.children[2].checked = true;
  el.parentNode.children[0].style.opacity = 1;
  if (el.parentNode.children[2].checked == true)
    postData.push("src=" + el.parentNode.children[0].src);
}

function encode_picture(element) {
  var filesSelected = element.files;
  if (filesSelected.length > 0) {
    var fileToLoad = filesSelected[0];
    var fileReader = new FileReader();
    fileReader.onload = function(fileLoadedEvent) {
      var srcData = fileLoadedEvent.target.result;
      if (postData.length > 0) {
        if (srcData.match(/png/)) {

          
          var data = srcData.replace("data:image/png;base64,", "");
          postData.push("base64=" + data);
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "../php/do_create_image.php", true);
          xhr.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded"
          );
          xhr.send(postData.join("&"));
          xhr.onreadystatechange = function(event) {
            if (this.readyState === 4) {
              if (this.status === 200) {
                if ((this.responseText))
                {
                  my_getEl("usearea_container", "block", "none");
                  photo.setAttribute("src", JSON.parse(this.responseText).file);
                }
                else my_function2("Oooops!!! Wrong format! Choose a png format!!");               
              }
            }
          };
        } 
        else my_function2("Oooops!!! Wrong format! Choose a png format!!");
      } 
      else my_function2("Please choose a frame");
      el = document.getElementsByClassName("active");
      el[0].parentNode.children[0].style.opacity = 1;
    };
    if (fileToLoad) fileReader.readAsDataURL(fileToLoad);
  }
}

(function() {
  var streaming = false,
    video = document.querySelector("#video"),
    cover = document.querySelector("#cover"),
    canvas = document.querySelector("#canvas"),
    photo = document.querySelector("#photo"),
    startbutton = document.querySelector("#startbutton"),
    width = 320,
    height = 0;

  navigator.getMedia =
    navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia;

  navigator.mediaDevices.getUserMedia({ audio: false, video: true })
  .then(function(stream) {
    if ("srcObject" in video) {
      video.srcObject = stream;
    } else {
      video.src = window.URL.createObjectURL(stream);
    }
    video.onloadedmetadata = function(e) {
      video.play();
    };
  })
  .catch(function(err) {
  });

  video.addEventListener(
    "canplay",
    function(ev) {
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth / width);
        video.setAttribute("width", width);
        video.setAttribute("height", height);
        canvas.setAttribute("width", width);
        canvas.setAttribute("height", height);
        streaming = true;
      }
    },
    false
  );

  function take_picture() {
    canvas.width = width;
    canvas.height = height;
    var ctx = canvas.getContext("2d");
    ctx.translate(width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL("image/png");
    postData.push("base64=" + data.replace("data:image/png;base64,", ""));
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/do_create_image.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(postData.join("&"));
    xhr.onreadystatechange = function(event) {
      if (this.readyState === 4) {
        if (this.status === 200) {
          my_getEl("usearea_container", "block", "none");
          photo.setAttribute("src", JSON.parse(this.responseText).file);
        }
      }
    };
  }

  startbutton.addEventListener(
    "click",
    function(ev) {
      if (postData.length > 0) take_picture();
      else my_function2("Please choose a frame");
      postData = [];
      el = document.getElementsByClassName("active");
      el[0].parentNode.children[0].style.opacity = 1;
      ev.preventDefault();
    },
    false
  );
})();

function my_function2(text_node, get_doc){
  var div = document.createElement("div");
  var p = document.createElement("p");
  var text2 = document.createTextNode(text_node);
  div.className = "alert alert-success";
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
  get_doc;
}

