function showLog(){
    $.ajax({
        url: "/api/show-log",
        type: 'GET',
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
        },
        success: function (data) {
            const contentlogs = $('#content-table-log');
            contentlogs.empty();
            console.log(data);
            data.forEach(log=> {
                const row = `
                    <tr>
                        <td class="pl-0">
                            <span class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">${log.id}</span>
                        </td>
                        <td>
                            <span  class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.admin.name}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.admin.email}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.data.id}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.data.name}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.action}</span>
                        </td>
                    </tr>
                `
                contentlogs.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.log("k thể xem log");
        }
    });
}

$(document).ready(function () {
    if (window.location.pathname === '/show-log')
        showLog(); // Gọi hàm của bạn khi trang load 
});