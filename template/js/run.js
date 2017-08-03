$(document).on('click', '.login-btn', function(e) {
    e.preventDefault();
    if ($('.login-panel').is(':visible')) {
        $('.login-panel').fadeOut(200);
    }
    else {
        $('.login-panel').fadeIn(200);
    }
});

// watch task preview
$(document).on('click', '.preview-btn', function() {
    if ($('.preview').is(':visible')) {
        $('.preview').fadeOut(200);
    }
    else {
        $('.preview').fadeIn(200);
        $('.preview-name').text($('.t-name').val());
        $('.preview-email').text($('.t-email').val());
        $('.preview-text').text($('.t-text').val());
    }
})

// get image for preview
$(document).on('change', '.load-img-btn', function() {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('.preview-image').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
});