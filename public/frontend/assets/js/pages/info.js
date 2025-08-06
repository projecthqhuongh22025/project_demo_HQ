function showInfor(){
    $.ajax({
        url: "/api/showinfo",
        type: 'GET',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (data) {
            console.log(data)
            $('#name').val(data.name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
        },
        error: function (xhr, status, error) {

        }
    });
}

function updateInfo(){
    const data = {
        email: $('#email').val(),
        name: $('#name').val(),
        phone: $('#phone').val(),
    };

    $.ajax({
        url: "/api/update-info",
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            alert("Cập nhật thông tin thành công");
            window.location.href = "/info"
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    $(`#${key}-error`).text(messages[0]);
                });
            }
        }
    });
}

$(document).on('click', '#update-info', function (event) {
    event.preventDefault();
    $('.error').text('');
    updateInfo();
});

$(document).ready(function () {
    if (window.location.pathname === '/info'){
        showInfor();
    }
});