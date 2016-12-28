<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
    <link href="{{asset('/auth/css/style.css')}}" rel='stylesheet' type='text/css' />
    <!--webfonts-->
    {{--<link href='http://fonts.useso.com/css?family=PT+Sans:400,700,400italic,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.useso.com/css?family=Exo+2' rel='stylesheet' type='text/css'>--}}
            <!--//webfonts-->
    <script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<script>$(document).ready(function(c) {
        $('.close').on('click', function(c){
            $('.login-form').fadeOut('slow', function(c){
                $('.login-form').remove();
            });
        });
    });
</script>
<!--SIGN UP-->
<h1>BugList Login Form</h1>
<div class="login-form">
    <div class="close"> </div>
    <div class="head-info">
        <label class="lbl-1"> </label>
        <label class="lbl-2"> </label>
        <label class="lbl-3"> </label>
    </div>
    <div class="clear"> </div>
    <div class="avtar">
        <img src="{{asset('/auth/images/avtar.png')}}" />
    </div>
    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}
        <input type="text" class="text" value="{{ old('name') }}" name="name" placeholder="Username" >
        <input type="text" class="text" value="{{ old('email') }}" name="email" placeholder="Email">
        <div class="key">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_confirmation" placeholder="PasswordConfirm">
        </div>
        <div class="signin">
            <input type="submit" value="Register" >
        </div>
    </form>
</div>
<div class="copy-rights">
    <p>Copyright &copy; 2016.木头疙瘩</p>
</div>

</body>
</html>