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

//Summer note WYSIWYG Editor Initiator
$('#post_description').summernote({
    placeholder: 'Enter Post Description...',
    tabsize: 4,
    height: 150,
    minHeight: 150,
    maxHeight: null,
    focus: false
});
$('#tags').tagsInput();

//Edit comment Modal Initiator in BlogPost Page
function editComment(comment) {
    console.log(comment);
    $("#comment_edit_form").attr("action", "\\comment/update/" + comment.id);
    $("#comment_edit_name").val(comment.user_name);
    $("#comment_edit_comment").val(comment.comment);
    $("#edit_comment_submit").prop("disabled", false);
}
function updateComment(form) {
    $("#edit_comment_submit").prop("disabled", true);
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
            $("#edit_comment_submit").prop("disabled", false);
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
