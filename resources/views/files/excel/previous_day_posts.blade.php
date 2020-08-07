<table>
    <thead>
    <tr>
        <th>Post Title</th>
        <th>Post Description</th>
        <th>Created By</th>
    </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
        <tr>
            <td>{{ $post->post_title }}</td>
            <td>{{ substr(html_entity_decode(strip_tags($post->post_description)), 0, 100) }}
                @if(strlen(html_entity_decode(strip_tags($post->post_description))) > 100) . . . @endif
            </td>
            <td>{{ $post->user->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
