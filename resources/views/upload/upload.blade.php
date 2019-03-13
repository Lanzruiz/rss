<html>
<body>
<head>

<script src="https://www.gstatic.com/firebasejs/3.8.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCfzReN-AvXMZ7sdiCpIvGVlJtPoDjuhYs",
    authDomain: "showcase-736ae.firebaseapp.com",
    databaseURL: "https://showcase-736ae.firebaseio.com",
    projectId: "showcase-736ae",
    storageBucket: "showcase-736ae.appspot.com",
    messagingSenderId: "830268542633"
  };
  firebase.initializeApp(config);
</script>
</head>
</body>
<script>

    var auth = firebase.auth();
    var storageRef = firebase.storage().ref();

    function handleFileSelect() {
      //evt.stopPropagation();
      //evt.preventDefault();
      //var file = document.getElementById("video").files[0];
     // console.log("filecontent {!!$file_content!!}");
      var blob = "{!! $file_content !!}";
      console.log(blob)
      var reader  = new FileReader();
       console.log(reader)
      data = reader.result;
      console.log(data);

      var file = data

      var metadata = {
        'contentType': file.type
      };

      // Push to child path.
      // [START oncomplete]
      storageRef.child('video-upload/' + file.name).put(file, metadata).then(function(snapshot) {
        console.log('Uploaded', snapshot.totalBytes, 'bytes.');
        console.log(snapshot.metadata);
        var url = snapshot.downloadURL;
        console.log('File available at', url);
       
      }).catch(function(error) {
        // [START onfailure]
        console.error('Upload failed:', error);
        // [END onfailure]
      });
      // [END oncomplete]
    }

    window.onload = function() {
     

      auth.onAuthStateChanged(function(user) {
        if (user) {
          console.log('Anonymous user signed-in.', user);
          handleFileSelect()
        } else {
          console.log('There was no anonymous session. Creating a new anonymous user.');
          // Sign the user in anonymously since accessing Storage requires the user to be authorized.
          auth.signInAnonymously();
        }
      });
    }
  </script>
</html>