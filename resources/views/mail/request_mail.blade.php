<!DOCTYPE html>
<html>
<head>
    <title>Attendance App</title>
</head>
<body>
	<label><b>Notification of request from {{$data['name']}}</b></label><br>
	<p>
		Name : {{$data['name']}}<br>
		Type : {{$data['type']}}<br>
		Reason : {{$data['desc']}}<br>
		Date : {{$data['date']}}<br>
	</p>
    <p>Thank you</p>
</body>
</html>