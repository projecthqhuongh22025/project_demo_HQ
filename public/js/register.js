document.addEventListener("DOMContentLoaded", function () {

    function register() {

        const data = {
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#confirmPassword').val(),
        };

        $.ajax({
            url: "http://localhost:8000/api/register",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                showActivationModal($('#email').val());
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    $(document).on('click', '.register-btn', function (event) {
        event.preventDefault();
        register();
    });

});