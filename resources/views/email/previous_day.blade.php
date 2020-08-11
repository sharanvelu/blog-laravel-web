<html>
<head>
    <title>Mail</title>
    <style>
        body {
            background: #edf2f7;
        }

        .center {
            margin: 0 auto;
            width: 550px;
        }

        .logo {
            height: 100px;
            max-height: 100px;
        }

        .content {
            font-family: 'Varela Round', Helvetica, Arial, sans-serif;
            border-radius: 5px;
            padding: 5px 30px 30px;
        }
    </style>
</head>
<body>
<header>
    <div class="center header" style="display:flex; justify-content: center">
        <a href="https://homestead.blog" style="text-decoration: none">
            <table>
                <tr>
                    <td>
                        <img class="logo" src="{{ $message->embed('http://homestead.blog/blog/images/topbar_logo.png') }}">
                    </td>
                </tr>
            </table>
        </a>
    </div>
</header>
<main>
    <div class="center content" style="background: white">
        <h3 style="text-align: center">
            Hello There, Good Morning
        </h3>
        <br>
        <br>
        <p>On the previous day(Yesterday - {{ $date }}), there are a total of {{ $post_count }} has been posted.</p>
        <p>We have attached two files consisting of Post Title and its description that has been created yesterday.</p>

        <h3 style="color: grey; text-align: right">Thanks,<br>Sharan Blog</h3>
    </div>
</main>
<footer>
    <div class="center">
        <div style="text-align: center; color: #797979; padding: 30px">
            © 2020 sharan-blog. All rights reserved.
        </div>
    </div>
</footer>
</body>
</html>

