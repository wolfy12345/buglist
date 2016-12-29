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
        <h1>REGISTER FORM</h1>
        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}
            <input type="text" class="text" value="{{ old('name') }}" name="name" placeholder="Username" >
            <input type="text" class="text" value="{{ old('email') }}" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_confirmation" placeholder="PasswordConfirm">

            <label><input type="radio" name="role" value="qa">测试</label>
            <label><input type="radio" name="role" value="rd">开发</label>

            <div class="forgot">
                <a href="#">forgot Password</a>
                <input type="submit" value="Register" >
            </div>
        </form>
    </div>
    <div class="login-bottom">
        <h3>New User &nbsp;<a href="/auth/login">Login</a>&nbsp Here</h3>
    </div>
</div>
<div class="copyright">
    <p>Copyright &copy; 2016.木头疙瘩</p>
</div>


</body>
</html>