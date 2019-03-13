<?php
header('Location: /');
 die();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page not found.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 20px;
            }
            .title_404 {
                font-size: 72px;
                margin-bottom: 20px;
                font-weight: bold;
                color: #ffc107!important;
            }
            .login {
                font-size: 25px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
              <div class="title_404">404</div>
              <div class="title">Opps! Page not found</div>
                <div class="login">Click <a href="{{url('/')}}">here</a> to login</div>
            </div>
        </div>
    </body>
</html>
