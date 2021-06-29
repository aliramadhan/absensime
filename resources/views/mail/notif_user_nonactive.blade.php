<!DOCTYPE html>
<html>
<head>
    <title>Attendance App</title>
</head>
<body>
	<label><b>List Employees can't start record tomorrow.</b></label><br>
	<ul>
	@foreach($data as $item)
		<li>{{$item}}</li>
	@endforeach
	</ul>
    <p>Thank you</p>
</body>
</html>