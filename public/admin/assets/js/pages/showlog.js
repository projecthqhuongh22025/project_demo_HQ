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
            console.log(data.data);
            data.data.forEach(function (log) {
                const dateVN = new Date(log.created_at);

                const formattedDate = dateVN.toLocaleString('vi-VN', {
                    timeZone: 'Asia/Ho_Chi_Minh',
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                const row = `
                    <tr>
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
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.data.email}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${log.action}</span>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${formattedDate}</span>
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