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

        .post-image {
            width: 100%;
            border-radius: 5px;
            @if($crud == 'deleted')
                border: #c73636 5px solid;
            @endif
        }

        .post-title {
            border: 2px solid #787878;
            border-radius: 5px;
            padding: 20px 7px;
            @if($crud == 'deleted')  text-decoration: line-through; @endif

        }

        .button {
            border-right: 2px solid #055000;
            border-bottom: 2px solid #055000;
            border-top: 2px solid #28a745;
            border-left: 2px solid #28a745;
            background: #28a745;
            color: white;
            border-radius: 5px;
            padding: 10px 50px;
        }

        .button:hover {
            background: #218838;
            border-top: 2px solid #218838;
            border-left: 2px solid #218838;
            cursor: pointer;
            color: white;
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
            {{ "Your post has been $crud Successfully" }}
        </h3>
        <br>
        <img class="post-image" src="{{ $message->embed(asset('storage/'.$post->image)) }}">
        <br>
        <h2 class="post-title" style="text-align: center; color: #7f7f7f;">
            {{ $post->post_title }}
        </h2>
        <br>
        <hr>
        <br>
        <div align="justify" style="@if($crud == 'deleted')  text-decoration: line-through; @endif">
            {{ print_r($post->post_description) }}
        </div>
        <br>
        <a href="{{ $link }}" style="margin-left: 38%">
            <button class="button">
                {{ $crud == 'deleted' ? 'Home' : 'View Post' }}
            </button>
        </a>

        <hr style="margin:30px 0 10px 0">

        <h3 style="color: grey; text-align: right">Thanks,<br>Sharan's Blog</h3>
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

