<!DOCTYPE html>
<html>
<head>
    <title>Attendance App</title>
</head>
<body>
	<label><b>Notification</b></label><br>
	<p>
		Hi, 
		@if($time < 60)
		Kamu terlambat masuk. 
		@else
		Kamu sudah melebihi batas 1 jam toleransi terlambat masuk. 
		@endif
		Ayo segera catat jam masuk. klik tautan <a href="attendance.pahlawandesignstudio.com">ini </a>

		Apakah hari ini kamu berhalangan masuk kerja?  
		Jangan lupa submit form ya :) 
		Apapun yang terjadi, semoga kamu bisa melewatinya. Semangat …
	</p>
    <p>Thank you</p>
</body>
<script type="text/javascript"> 
    var notify;
   
    // jika notifikasi di izinkan
    if(Notification.permission == 'granted'){
      notify = new Notification("Attendance Notification",{
        // judul notifikasi
        body : "Kamu terlambat masuk",
        // icon notifikasi
        icon : "{{ asset('image/logo.png') }}"
      });
    }

</script>
</html>