//Add Comment through AJAX in BlogPost page
function addComment(form) {
    $('#comment_error').hide();
    $('#name_error').hide();
    $('#website_error').hide();
    $('#email_error').hide();
    $.ajax({
        url: form.action,
        type: "POST",
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function () {
            $("#comment_list").load(location.href + " #comment_list");
            $("#comment_name").val('');
            $("#comment_email").val('');
            $("#comment_website").val('');
            $("#comment_comment").val('');
        },
        error: function (error) {
            if (error.responseJSON.errors.name) {
                $('#name_error').html(error.responseJSON.errors.name).show();
            }
            if (error.responseJSON.errors.email) {
                $('#email_error').html(error.responseJSON.errors.email).show();
            }
            if (error.responseJSON.errors.comment) {
                $('#website_error').html(error.responseJSON.errors.website).show();
            }
            if (error.responseJSON.errors.comment) {
                $('#comment_error').html(error.responseJSON.errors.comment).show();
            }
        }
    })
}

//Select All Permissions in Assign Role
$(document).ready(function () {
    $('#select_all').click(function () {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
});

//Edit comment Modal Initiator in BlogPost Page
function editComment(comment) {
    $("#comment_edit_form").attr("action", "\\comment/update/" + comment.id);
    $("#comment_edit_name").val(comment.user_name);
    $("#comment_edit_comment").val(comment.comment);
    $("#comment_edit_submit").prop("disabled", false);
}
function updateComment(form) {
    $("#comment_edit_submit").prop("disabled", true);
    $('#comment_edit_name_error').hide();
    $('#comment_edit_comment_error').hide();
    $.ajax({
        url: form.action,
        type: "POST",
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function () {
            // document.location.reload(true);
            $("#comment_list").load(location.href + " #comment_list");
            $('#cancel_modal').click();
        },
        error: function (error) {
            $("#comment_edit_submit").prop("disabled", false);
            if (error.responseJSON.errors.name) {
                $('#comment_edit_name_error').html(error.responseJSON.errors.name).show();
            }
            if (error.responseJSON.errors.comment) {
                $('#comment_edit_comment_error').html(error.responseJSON.errors.comment).show();
            }
        }
    })
}

//Delete comment Initiator in blogPost
function deleteComment(comment, form) {
    swal({
        title: "Are you sure to delete this Comment?",
        text: "Name : " + comment.user_name + "\nComment : " + comment.comment,
        icon: "warning",
        buttons: {
            cancel: true,
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: false,
            }
        },
        dangerMode: true,
    }).then((value) => {
        if (value) {
            $.ajax({
                url: '\\comment/delete/' + comment.id,
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (success) {
                    swal({
                        title: "Delete Comment Successful",
                        text: "Comment by : " + comment.user_name +
                            "\nComment : " + comment.comment,
                        icon: "success",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                        timer: 2000,
                    });
                    $("#comment_list").load(location.href + " #comment_list");
                },
                error: function (error) {
                    swal({
                        title: 'Could not delete the Comment',
                        text: `Error :  ${error}`,
                        icon: "danger",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                        timer: 2000,
                    });
                }
            });
        }
    });
}

//Delete Post Swal Initiator in blogPost
function deletePost(post, posted_by, form) {
    swal({
        title: "Are you sure to delete this Post?",
        text: "Post Title : " + post.post_title + "\nPosted By : " + posted_by,
        icon: "warning",
        buttons: {
            cancel: true,
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: false,
            }
        },
        dangerMode: true,
    }).then((value) => {
        if (value) {
            $.ajax({
                url: '\\post/delete/' + post.id,
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (success) {
                    swal({
                        title: "Delete Post Successful",
                        text: "Post Title : " + post.post_title + "\nPosted By : " + posted_by,
                        icon: "success",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                        timer: 2000,
                    }).then((value) => {
                        window.location.href = page_load_url();
                    });
                },
                error: function (error) {
                    swal({
                        title: 'Could not delete the Post',
                        text: `Error :  ${error}`,
                        icon: "danger",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                        timer: 2000,
                    });
                }
            });
        }
    });
}
function page_load_url() {
    var pathname = window.location.pathname;
    var split = pathname.split('/');
    var final_url = "";
    if (split.length > 3){
        final_url = "/" + split[1] + "/" + split[2] + "/";
        return window.location.origin + final_url;
    }
    return window.location.href;
}

//Allow or Deny new user to be registered through /register Route
function NewUserToggle(form) {
    var action = '';
    action = !!$('#new_user_toggle').prop('checked');
    $.ajax({
        url: '\\user/new/' + action,
        type: "POST",
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function () {
            $("#new_user_toggle_form").load(location.href + " #new_user_toggle_form");
            var icon = '';
            var yes_or_no = '';
            action ? icon='success' : icon='info';
            action ? yes_or_no='' : yes_or_no='not ';
            action ? action='Allow' : action="Deny";
            swal({
                title: action + 'ing New Users',
                text: 'New Users are ' + yes_or_no + 'allowed to register using \'register Route',
                icon: icon,
                buttons: {
                    cancel: {
                        text: "Close",
                        visible: true,
                        closeModal: true,
                    }
                },
                timer: 2000,
            });
        },
        error: function (error) {
            swal({
                title: 'Could not toggle',
                text: `Error :  ${error}`,
                icon: "error",
                buttons: {
                    cancel: {
                        text: "Close",
                        visible: true,
                        closeModal: true,
                    }
                },
                timer: 2000,
            });
        }
    });
}

