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
            <form action = "register" method = "post">
                <div class = "nick_box">
                     <label class = "item" for = "nick">昵称</label>
                    <input type = "text" id = "nick" name = "nick">
                </div>
                <div class = "password_box">
                     <label class = "item" for = "nick">密码</label>
                    <input type = "password" id = "password" name = "password">
                </div>
                <div class = "phone_box">
                     <label class = "item" for = "phone">手机</label>
                    <input type = "phone" id = "phone" name = "nick">
                </div>
                <input type = "submit" value = "注册">
            </form>
        </div>
    </body>
</html>
