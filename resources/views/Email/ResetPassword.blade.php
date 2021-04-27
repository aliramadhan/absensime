<!DOCTYPE html>
<html>
<head>
  <title>24Slides Catering App</title>
  <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' http://* 'unsafe-inline'; script-src 'self' http://* 'unsafe-inline' 'unsafe-eval'" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
  
  <style type="text/css">
    body,html{
      font-family: 'Poppins', sans-serif;
      background-color: transparent;
    }
  </style>
</head>
<body>
  <div style="padding: 2em 1em 2em 1em;
  min-height: 100vh;
  background: #f1f1f1;">

  <div style="    max-width: 28rem;
  margin-left: auto;
  margin-right: auto;">

  <div style="background: #fff;box-shadow: 0 4px 6px -1px rgb(0 0 0 / 10%), 0 2px 4px -1px rgb(0 0 0 / 6%);padding: 2em">
    <div style="background-color:#F05252;   
    letter-spacing: 0.025em;
    text-align: center;
    margin-top: -2rem;
    margin-left: -2rem;
    margin-right: -2rem;
    height: 7rem;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    display: flex;">
    
    <p style="    color: #ffffff;
    font-size: 1.5rem;">Admin Resetting your Password Successfully! </p>
  </div>

  <div style="    padding:2em;background-color: #fff;border-bottom-width: 1px;">
  <p>
    Hey {{$data['name']}}!<br><br>
    Congratulations, your password has been successfully reseted by admin.<br>        
    Now you can use this catering application by entering your following email and your new password<br><br>
    This your password:  <b>{{$data['password']}}</b> <br><br> 
    You can also change it on the profile view on the webpage.<br> Access your account here:
    <a href="https://catering.pahlawandesignstudio.com/" style="
    text-decoration: none;font-weight: 600;">catering.pahlawandesignstudio.com</a>  

  </p>
  <br>
  <p style="    font-size: 0.875rem;">
    Best Regard!<br>
    <a href="mailto:ainun@24slides.com&subject=My%20Ask&body=for Employee Happiness" style="text-decoration: none;font-weight: 600;color: #000000;"><i>Employee Happiness</i></a>
    
  </p>
</div>



</div>

<div style="text-align: center;
margin-top: 2rem;
font-size: 0.875rem;">

<div >
  <p style="    line-height: 2;">
    Questions or concerns? <a href="mailto:sigit@24slides.com?&cc=fajarfaz@gmail.com&subject=My%20Ask&body=your subject" style="    margin-left: 0.5rem;
    font-weight: 600;
    color: #071121;
    text-decoration: none;">Email Us</a>

    
  </p>
</div>

</div>


</div>

</div>

</body>
</html>