<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        

        <style>
            html, body {
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

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form action = "login" method = "post">
                <div class = "account_box">
                     <label class = "item" for = "account">账号</label>
                    <input type = "text" id = "account" name = "account">
                </div>
                <div class = "password_box">
                     <label class = "item" for = "password">密码</label>
                    <input type = "password" id = "password" name = "password">
                </div>
                <input type = "submit" value = "登录">
            </form>
        </div>
    </body>
</html>
