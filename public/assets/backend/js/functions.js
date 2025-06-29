/*======== Preloaders =========*/
function start_load(){
    $('body').prepend('<di id="preloader2"></di>')
}

function end_load(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
    })
}

/*======== Delete Item =========*/
function delete_item(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {
                'id': id,
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    window.location.reload();
                    Swal.fire('Deleted!',response.status,'success');
                }
            });
        }

    });
};

/*======== Show Error in Fields =========*/
function showError(field, message){
    if (!message) {
        $("#"+field).addClass("is-valid").removeClass("is-invalid").siblings(".invalid-feedback").text("");
    }else{
        $("#"+field).addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text(message);
    }
}

/*======== RemoveValidationClasses =========*/
function removeValidationClasses(form){
    $(form).each(function () {
       $(form).find(":input").removeClass("is-valid is-invalid");
    });
}

/*======== Show Alert Message =========*/
function showMessage(type, message){
    return `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
    <strong>${message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>`;
}

/*======== Is Image file Valid =========*/
function isValidFile(inputSelector, validationMessageSelector) {
    var ext = $(inputSelector).val().split('.').pop().toLowerCase();

    if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        $(inputSelector).val('');
        $(validationMessageSelector).removeClass('d-none');
        $(validationMessageSelector).html('The image must be a file of type: jpeg, jpg, png.').show();
        return false;
    }

    $(validationMessageSelector).hide();
    return true;
};

/*======== Display Photo =========*/
function displayPhoto(input, selector) {
    var displayPreview = true;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        var image = new Image();
        image.src = e.target.result;

        image.onload = function () {
            $(selector).attr('src', e.target.result);
            displayPreview = true;
        };
        };

        if (displayPreview) {
        reader.readAsDataURL(input.files[0]);
        $(selector).show();
        }
    }
};

/*======== Edit Language Phrases =========*/
function updatePhrase(key, language, url, message) {

    $('#btn-'+key).attr('disabled', true);
    $('#phrase-'+key).attr('disabled', true);
    var updatedValue = $('#phrase-'+key).val();
    var currentEditingLanguage = language;
    start_load();

    $.ajax({
        type : "POST",
        url  : url,
        data : {
            'updatedValue' : updatedValue,
            'currentEditingLanguage' : currentEditingLanguage,
            'key' : key
        },
        success : function(response) {
            end_load();
            $('#btn-'+key).html('<i class = "lni lni-checkmark"></i>');
            $('#btn-'+key).attr('disabled', false);
            $('#phrase-'+key).attr('disabled', false);

            tata.success("Success", message, {
            position: 'tr',
            duration: 3000,
            animate: 'slide'
            });

        }
    });
}

/*======== Show Reply Form =========*/
function show_reply_form(comment_id){

    $("#reply-form-"+comment_id).toggle();
}


function markAsRead() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $(this);
    $.ajax({
        url: APP_URL + "/user/mark-as-read",
        method: 'post',
        dataType: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function(t) {
            1 == t.bool && $("#notify").text(0)
        }
    })
}

function markAsReadTwo() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $(this);
    $.ajax({
        url: APP_URL + "/user/mark-as-read",
        method: 'post',
        dataType: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function(t) {
            window.location.reload();
        }
    })
}

function savePost(t) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $(this);
    $.ajax({
        url: APP_URL + "/user/save_favorite",
        type: "POST",
        dataType: "json",
        data: {
            item: t,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function(e) {
            var p;
            1 == e.bool ? ($("#save-icon-" + t).removeClass("text-muted").addClass("text-danger"), p = $("#save-" + t).text(), $("#save-" + t).text(++p)) : 0 == e.bool && ($("#save-icon-" + t).removeClass("text-danger").addClass("text-muted"), p = $("#save-" + t).text(), $("#save-" + t).text(--p))
        },
        error: function(e) {

            tata.error("Error", 'Please Login to Bookmark the Post', {
            position: 'tr',
            duration: 3000,
            animate: 'slide'
            });
        }
    })
}


function report(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, report it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {'id': id,};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    Swal.fire('Reported!',response.status,response.action);
                }
            });
        }

    });
}

function share(url, id, type) {

    var data = {'id': id, 'type' : type};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function (response) {
        }
    });

}

function reactPost(a, type) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + "/react",
        method: "POST",
        dataType: "json",
        data: {item: a, type: type},
        success: function(response) {


            if (response.status == 200) {

                $("#react-icon-like-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-love-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-haha-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-mad-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-sad-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-wow-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-yay-"+ a).removeClass("shown").addClass("hiden");

                $("#react-icon-" + type +"-"+ a).removeClass("hiden").addClass("shown");

                tata.success("Success", response.messages, {
                    position: 'tr',
                    duration: 3000,
                    animate: 'slide'
                });

            }else if(response.status == 202){

                $("#react-icon-like-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-love-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-haha-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-mad-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-sad-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-wow-"+ a).removeClass("shown").addClass("hiden");
                $("#react-icon-yay-"+ a).removeClass("shown").addClass("hiden");

                tata.success("Success", response.messages, {
                    position: 'tr',
                    duration: 3000,
                    animate: 'slide'
                });

            }else if(response.status == 402){

                tata.error("Error", response.messages, {
                    position: 'tr',
                    duration: 3000,
                    animate: 'slide'
                });

            }
        }
    })
}

function pin(url, id) {

    start_load();
    var data = {'id': id};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function (response) {
            end_load();

            tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
            });

            window.location.reload();
        }
    });

}

function mark(url, id, post_id) {

    start_load();
    var data = {'id': id, 'post_id': post_id};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function (response) {
            end_load();

            tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
            });

            window.location.reload();
        }
    });

}

function close_post(id) {

    start_load();
    var data = {'id': id};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: APP_URL + "/user/posts/close",
        data: data,
        success: function (response) {
            end_load();

            tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
            });

            window.location.reload();
        }
    });

}

function open_post(id) {

    start_load();
    var data = {'id': id};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: APP_URL + "/user/posts/open",
        data: data,
        success: function (response) {
            end_load();

            tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
            });

            window.location.reload();
        }
    });

}

function cancel_sub(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'No!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {'id': id,};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    Swal.fire('Subscription!',response.status,response.action);
                    window.location.reload();
                }
            });
        }

    });
}

function paid(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {'id': id,};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    Swal.fire('Withdrawals!',response.status,response.action);
                    window.location.reload();
                }
            });
        }

    });
}

function remove_ban(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {'id': id,};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    Swal.fire('Ban!',response.status,response.action);
                    window.location.reload();
                }
            });
        }

    });
}

function block(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {'id': id,};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    Swal.fire('Block!',response.status,response.action);
                    window.location.reload();
                }
            });
        }

    });
}

function delete_chat(id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {
                'id': id,
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: APP_URL + "/admin/chats/delete",
                data: data,
                success: function (response) {
                    end_load();
                    window.location = APP_URL + "/admin/chats";
                    Swal.fire('Deleted!',response.status,'success');
                }
            });
        }

    });
}

function delete_post(url, id, message) {

    Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1cbb8c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed)
        {
            start_load();

            var data = {
                'id': id,
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function (response) {
                    end_load();
                    window.location = APP_URL + "/posts";
                    Swal.fire('Deleted!',response.status,'success');
                }
            });
        }

    });
}

$("#search").on('keyup',function(){

	var search_term = $('#search').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + "/search",
        data: {'search_term': search_term},
        success: function(response) {
            $('#searchResults').html(response);
        }
    });

});
