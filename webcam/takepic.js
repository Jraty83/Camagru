(function() {
	var width = 320;    // We will scale the photo width to this
	var height = 0;     // This will be computed based on the input stream
  
	var streaming = false;
  
	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;
	var uploadbutton = null;
	var submitbutton = null;

	function startup() {
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('startbutton');
		uploadbutton = document.getElementById('fileToUpload');
		submitbutton = document.getElementById('submitbutton');

		navigator.mediaDevices.getUserMedia({ video: true, audio: false })
		.then(function(stream) {
			video.srcObject = stream;
			video.play();
		})
		.catch(function(err) {
			console.log("An error occurred: " + err);
		});

		video.addEventListener('canplay', function(ev) {
			if (!streaming) {
			  //todo COMMENT NEXT LINE ??
			  height = video.videoHeight / (video.videoWidth/width);
	  
			  video.setAttribute('width', width);
			  video.setAttribute('height', height);
			  canvas.setAttribute('width', width);
			  canvas.setAttribute('height', height);
			  streaming = true;
			}
		}, false);

		startbutton.addEventListener('click', function(ev) {
			takepicture();
			ev.preventDefault();
			submitbutton.disabled = false;
		}, false);

		uploadbutton.addEventListener('change', function(ev) {
			submitbutton.disabled = false;
		}, false);

		clearphoto();
	}

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);
	
		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	function takepicture() {
		var context = canvas.getContext('2d');
		if (width && height) {
		  canvas.width = width;
		  canvas.height = height;
		  context.drawImage(video, 0, 0, width, height);
	
		  var data = canvas.toDataURL('image/png');
		  // console.log(height);
		  photo.setAttribute('src', data);
		  //new line
		  document.getElementById("cpt_1").value = data;
		  } else {
		  clearphoto();
		}
	}
	window.addEventListener('load', startup, false);
})();
