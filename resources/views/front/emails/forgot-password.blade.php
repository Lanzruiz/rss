<html>
<body>
  <div style='width: 100%; background-color:#070f71; padding:5px;'>
      <img src='{{url('public/assets/images/main-logo.png')}}' width='200px'>
  </div>
  <p>Hi {{$fullname}}</p>
  <p>A request to change the password on your account was made.</br></br></p> <a href="{{url('new-password/'.$security)}}"> Reset Your Password</a></p>

  <p>If you do not want to change your password, please ignore this message.</p>
  
</body>
</html>
