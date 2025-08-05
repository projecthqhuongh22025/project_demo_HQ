@extends('layouts.admin.master')
@section('content')
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Danh sách Log</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-0">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center"
                id="kt_advance_table_widget_2">
                <thead>
                    <tr class="text-uppercase">
                        <th class="pl-0">id</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Khóa/Mở khóa</th>
                    </tr>
                </thead>
                <tbody id="content-table">
                    
                </tbody>
            </table>
        </div>

        <!--end::Table-->
    </div>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 3px;
        }
    </style>
    
    <!--end::Body-->
</div>
@endsection