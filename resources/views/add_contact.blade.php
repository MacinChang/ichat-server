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
            <form action = "add-contact" method = "post">
                <div class = "account_box">
                     <label class = "item" for = "from">己方</label>
                    <input type = "text" id = "from" name = "from">
                </div>
                <div class = "account_box">
                     <label class = "item" for = "to">对方</label>
                    <input type = "text" id = "to" name = "to">
                </div>
                <input type = "submit" value = "添加好友">
            </form>
        </div>
    </body>
</html>
