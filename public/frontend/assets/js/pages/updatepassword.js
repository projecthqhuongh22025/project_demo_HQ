function updatePassword(){
    const data = {
        current_password: $('#current_password').val(),
        new_password: $('#new_password').val(),
        new_password_confirmation: $('#new_password_confirmation').val(),
    };

    $.ajax({
        url: "/api/update-password",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            alert("Thay đổi mật khẩu thành công");
            window.location.href = "/"
        },
        error: function (xhr, status, error) {
            console.log(xhr.status);
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                console.log(errors);
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
        }
    });
}

$(document).on('click', '#resetpassword-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    updatePassword();
});