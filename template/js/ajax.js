// if we enter on the page first time, we are redirecting on first page, else on last opened page
$(document).ready(function() {
    var page = getCookie('page');
    var url = page == null ? 'page-' + 1 : 'page-' + page;
    $.ajax({
        type: 'POST',
        url: url,
        success: function(e) {
            $('.ajax-table').html(e);
        }
    });
});

$(document).on('click', '.login-request', function(e) {
    e.preventDefault();
    var formData = new FormData(document.forms.loginForm);
    $.ajax({
        type: 'POST',
        url: $('.login-form').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            location.reload();
        }
    });
});

$(document).on('click', '.logout-btn', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'logout',
        success: function() {
            location.reload();
        }
    });
});

// to fill 'name' and 'email' fields, like it's one user
$(document).on('click', '.add-task-btn', function() {
    var name = getCookie('name');
    var email = getCookie('email');
    if (name != null && email != null) {
        $('.t-name').val(name.replace(/\+/gi, ' ')).prop('disabled', true);
        $('.t-email').val(email).prop('disabled', true);
    }
});

$(document).on('click', '.save-task-btn', function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');  // to get row where are 'text' and 'status' cells
    var id = $(this).data('id');
    var text = row.children().find('textarea').val();
    var status = row.children().find('input[type="checkbox"]').is(':checked') == false ? 0 : 1; // convert values from status checkbox to boolean
    $.ajax({
        type: 'POST',
        url: 'edittask',
        data: {
            'id' : id,
            'text': text,
            'status' : status
        },
        success: function() {
            row.css('background', '#fff7b4');
        }
    });
});

$(document).on('click', '.send-task', function(e) {
    e.preventDefault();
    var formData = new FormData(document.forms.taskForm);
    var id = getCookie('id');
    if (id != null) {
        formData.append('id', id);
    }
    formData.append('image', $('.load-img-btn').prop('files')[0]);
    $.ajax({
        type: 'POST',
        url: $('.task-form').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            $.ajax({
                type: 'POST',
                url: 'page-1',
                success: function(e) {
                    $('.ajax-table').html('');
                    $('.ajax-table').html(e);
                }
            });
            // clear task form and preview window
            $('.close').trigger('click');
            $('.task-form').get(0).reset();
            $('.preview-image').attr('src', '');
            $('.load-img-btn').val('');
        }
    });
});

$(document).on('click', '.pagination li a', function(e) {
    e.preventDefault();
    if ($(this).attr('href') == '#') {
        return false;
    }
    var url = $(this).attr('href').slice(1); // delete '/' from url
    $.ajax({
        type: 'POST',
        url: url,
        success: function(e) {
            $('.ajax-table').html('');
            $('.ajax-table').html(e);
        }
    });
});

function getCookie(cookieName)
{
    var matches = document.cookie.match(new RegExp("(?:^|; )" + cookieName.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : null;
}