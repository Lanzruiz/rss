var config = {
    apiKey: "AIzaSyD0TEuPaUHO7YJuEKLXvnHvkELREaqzy-U",
    authDomain: "smartglass-aed6d.firebaseapp.com",
    databaseURL: "https://smartglass-aed6d.firebaseio.com",
    projectId: "smartglass-aed6d",
    storageBucket: "smartglass-aed6d.appspot.com",
    messagingSenderId: "1071895582447"
  };
  firebase.initializeApp(config);

   firebase.auth().signInAnonymously().catch(function(error) {
          // Handle Errors here.
          var errorCode = error.code;
          var errorMessage = error.message;
          // [START_EXCLUDE]
          if (errorCode === 'auth/operation-not-allowed') {
            alert('You must enable Anonymous auth in the Firebase Console.');
          } else {
            console.error(error);
          }
          // [END_EXCLUDE]
        });