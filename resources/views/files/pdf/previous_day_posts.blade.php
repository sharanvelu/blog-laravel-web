<html>
<head>
    <title>Previous day Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .title {
            font-size: xx-large;
            font-family: "Segoe UI", serif;
            text-align: center;
            margin: 10px
        }

        .post {
            margin: 10px;
            padding: 15px;
            border-radius: 5px;
            background: #c1c1c1;
            color: black;
        }

        .post-title {
            font-family: Arial, serif;
            font-weight: bold;
            font-size: large;
            margin-bottom: 15px;
        }

        .post-description {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .data {
            background: #a5a5a5;
            border-radius: 5px;
            padding: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<main style="background: #6b6b6b; border-radius: 5px; margin-bottom: 15px">
    <div style="padding: 10px; color: white">
        <div class="title">Sharan Blog</div>
        <div style="font-size: small; text-align: center; margin: 10px">
            <strong>Posted On : </strong>{{ $date }}
        </div>
    </div>
</main>

<div style="background: #e5e5e5; border-radius: 5px">
    <!-- Posts Beginning -->
    <div style="padding: 10px">
        @foreach($posts as $post)
            <div class="post">
                <div class="post-title">
                    {{ $post->post_title }}
                </div>
                <div class="post-description">
                    {{ substr(html_entity_decode(strip_tags($post->post_description)), 0, 100) }}
                    @if(strlen(html_entity_decode(strip_tags($post->post_description))) > 100) . . . @endif
                </div>
                <div class="data">
                    <div style="text-align: center">
                        <strong>Created By : </strong>{{ $post->user->name }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Posts Ending -->
</div>
</body>
</html>
