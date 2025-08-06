function getUser() {
    $.ajax({
        url: "/api/get-user",
        type: 'GET',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (data) {
            const users = $('#users-table');
            users.empty();
            data.forEach(function (user) {
                const row = `
                    <tr>
                        <td>
                            <span  class="text-dark-75 font-weight-bolder d-block font-size-lg">${user.name}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${user.email}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${user.phone}</span>
                        </td>
                        <td>
                            <style>
                                .color-option{
                                    background-color: #1BC5BD;
                                    border-color: #1BC5BD;
                                    border-radius: 0.42rem;
                                    color: white;
                                    font-weight: 500;
                                }
                            </style>
                            <button style="height:23px;border:none;cursor: default;" class="color-option">${user.role}</button>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${user.is_active === 1 ? 'Kích hoạt' : 'Chưa kích hoạt'}</span>
                        </td>
                        <td>
                            <button id="btnLockAndUnlock" type="button" data-id="${user.id}" style="height:23px;border:none;background-color: ${user.is_locked === 1 ? 'green' : 'red'};" class="color-option">
                                ${user.is_locked === 1 ? 'Mở khóa' : 'Khóa'}</button>
                        </td>
                        <td class="pr-0 text-right">
                            <a id="editModalBtn" data-id="${user.id}" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                            <a id="deleteIconBtn" data-id="${user.id}" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                        </td>
                    </tr>
                `;
                users.append(row);
            });

        },
        error: function (xhr, status, error) {
            console.log("k thể lấy danh sách");
        }
    });
}

function addUser() {
    const data = {
        email: $('#email').val(),
        name: $('#name').val(),
        phone: $('#phone').val(),
        password: $('#password').val(),
        password_confirmation: $('#confirmPassword').val(),
        role: $('#role').val(),
    };

    $.ajax({
        url: "/api/add-user",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            alert("Thêm tài khoản mới thành công");
            window.location.href = "/account"
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

function showEditForm(userId) {

    $.ajax({
        url: "/api/get-user-id/" + userId,
        type: 'GET',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (data) {
            $('#addUser-btn').hide();
            $('#updateUser-btn').show();
            $('#updateUser-btn').attr('data-id', userId);
            $('#name').val(data.name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#role').val(data.role);
        },
        error: function (xhr, status, error) {

        }
    });
}

function updateUser(userId) {
    const data = {
        email: $('#email').val(),
        name: $('#name').val(),
        phone: $('#phone').val(),
        role: $('#role').val(),
    };

    $.ajax({
        url: "/api/update-user/" + userId,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            alert("Cập nhật tài khoản mới thành công");
            window.location.href = "/account"
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

function deleteUser(userId){
    $.ajax({
        url: "/api/delete-user/" + userId,
        type: 'DELETE',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            location.reload();
        },
        error: function (xhr, status, error) {

        }
    });
}

function lockAndUnlock(userId){
    $.ajax({
        url: "/api/lock-user/" + userId,
        type: 'PUT',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (response) {
            location.reload();
        },
        error: function (xhr, status, error) {

        }
    });
}

$(document).on('click', '#openModalBtn', function (event) {
    $('#row-password, #row-confirmPassword').show();
    const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
    modal.show();
});

$(document).on('click', '#editModalBtn', function (event) {
    const userId = $(this).data('id');
    $('#row-password, #row-confirmPassword').hide();
    const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
    modal.show();
    showEditForm(userId);
});

$(document).on('click', '#updateUser-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    const userId = $(this).data('id');
    updateUser(userId);
});

$(document).on('click', '#deleteIconBtn', function (event) {
    event.preventDefault();
    const userId = $(this).data('id');
    if (confirm("Bạn có chắc chắn muốn xóa?")) {
        deleteUser(userId);
    }
});

$(document).on('click', '#addUser-btn', function (event) {
    event.preventDefault();
    $('.error').text('');
    addUser();
});

$(document).on('click', '#btnLockAndUnlock', function (event) {
    event.preventDefault();
    const userId = $(this).data('id');
    console.log(userId);
    const $button = $(this);
    const currentText = $button.text().trim();
    const confirmText = currentText === 'Khóa'
        ? 'Bạn muốn KHÓA tài khoản?'
        : 'Bạn muốn MỞ KHÓA tài khoản?';
    if (confirm(confirmText)) {
        lockAndUnlock(userId);
    }
});

$(document).ready(function () {
    if (window.location.pathname === '/account')
        getUser(); // Gọi hàm của bạn khi trang load 
});

