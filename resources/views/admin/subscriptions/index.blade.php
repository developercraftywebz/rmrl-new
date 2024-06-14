@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <nav aria-label="breadcrumb" class="my-2">
                    <div class="d-flex justify-content-between">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Plans</li>
                        </ol>

                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('plans.create') }}">Add a plan</a>
                                /
                                <a href="{{ route('plans.index') }}">Show all Plans</a>
                            </li>
                        </ol>
                    </div>
                </nav>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Plans</h6>
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
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Amount($)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Created At</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Amount($)</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('subscriptions.index') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function(data, type, full, meta) {
                            return full.user_name;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'stripe_status',
                        name: 'stripe_status'
                    },
                ]
            });
        });
    </script>
@endsection
