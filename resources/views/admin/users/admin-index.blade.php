<?php

use App\Enums\UserTypes;

?>

@extends('layouts.dashboard')

@section('content')

    <style>
        .action_btn{
            min-width: 50px;
            margin-left: 10px;
        }

        .content-page {
    margin-left: 110px;
    overflow: hidden;
    padding: 70px 15px 65px 15px;
    min-height: 80vh;
}
    </style>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" class="my-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admin</li>
                    </ol>
                </nav>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Admin</h6>
                        <div>
                            <!-- @if (request()->segment(3) == UserTypes::User || request()->segment(3) == UserTypes::Moderator)
                                <a href="{{ route('users.create', ['type' => request()->segment(3)]) }}"
                                    class="btn btn-primary">
                                    Add User
                                </a>
                            @endif -->
                           
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has('flash_error'))
                            <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                        @endif

                        @if (session()->has('flash_success'))
                            <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Created At</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Created At</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function($) {
            var table = $('#dataTable').DataTable({
                "pagingType": "full_numbers",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.index') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'state',
                        name: 'state'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var badgeClass = (data == 1) ? 'badge badge-success bg-success' :
                                'badge badge-danger bg-danger';
                            var statusText = (data == 1) ? 'Activated' : 'Disabled';
                            return '<span class="' + badgeClass + '">' + statusText + '</span>';
                        }
                    },
                
                ]
            });
        });
    </script>
@endsection
