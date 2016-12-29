<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <!-- Custom Theme files -->
    <link href="{{asset('/auth/css/style.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom Theme files -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <!--Google Fonts-->
    <!--Google Fonts-->
</head>
<body>
<div class="login">
    <h2>BugList Form</h2>
    <div class="login-top">
        <h1>LOGIN FORM</h1>
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}
            <input type="text" value="{{ old('email') }}" placeholder="Email" name="email">
            <input type="password" name="password" placeholder="Password">

            <div class="forgot">
                <a href="#">forgot Password</a>
                <input type="submit" value="Login" >
            </div>
        </form>
    </div>
    <div class="login-bottom">
        <h3>New User &nbsp;<a href="/auth/register">Register</a>&nbsp Here</h3>
    </div>
</div>
<div class="copyright">
    <p>Copyright &copy; 2016.木头疙瘩</p>
</div>


</body>
</html>