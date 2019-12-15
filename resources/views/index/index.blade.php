<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>

    <style>

        body{
            font-size: 15px;
            background-color: #3b4453;
            color: #ffffff;
            font-family: verdana;
            font-weight: bold;
        }
        .main_section{
            width: 90%;
            margin: 0 auto;
            text-align: center;

        }
        .main_menu{
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .main_menu li a{
            color: #ffffff;
            display: inline-block;
            /*text-decoration: none;*/
        }
        .main_menu li a:hover{
            /*text-decoration: underline;*/
            text-decoration: none;
        }
    </style>

</head>
<body>

    <section class="main_section">
        <h2>Events application</h2>
        <h4>&copy; <?=date('Y')?> Martin German</h4>
        <ul class="main_menu">
            <li>
                <a href="/event">Events</a>
            </li>
            <li>
                <a href="/tests">Tests</a>
            </li>
            <li>
                <a href="https://cp-remont-kvartir.hardweb.pw">RemontKvartir.NET</a>
            </li>
            <li>
                <a href="https://cp-cooldesc.hardweb.pw">CoolDESC</a>
            </li>
        </ul>
    </section>

</body>
</html>