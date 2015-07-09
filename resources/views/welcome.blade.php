<!DOCTYPE html>
<html>
    <head>
        <title>注册成功</title>
        <style>
            html, body {
                background:url(../user/images/login/bg.jpg);
                background-size:cover;
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
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
            .head{
                color: white;
                font-family: "YaHei Consolas Hybrid";
            }
            .title {
                font-size: 96px;
                color: red;
                font-family: "YaHei Consolas Hybrid";
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 class = "head">你的iChat号码是</h1>
                <div class="title">{{$account}}</div>
            </div>
        </div>
    </body>
</html>
