<html>
<head>
	<title>Test upload to firebase</title>
	<body>
		<form method="post" action="{{url('v1/upload/video')}}" enctype="multipart/form-data">
		Upload File: <input type="file" name="video"></br>
		<input type="hidden" name="deviceID" value="1111">
		<input type="hidden" name="type" value="audio">

		<input type="submit" name="submit" value="Send Video">

	</body>
</head>
</html>