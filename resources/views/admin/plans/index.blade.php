@extends('layouts.dashboard')

@section('content')
    <style>
        #dataTable_previous {
            margin: 0px 5px 0px 0px;
        }

        #dataTable_next {
            margin: 0px 0px 0px 5px;
        }

        .plan_view_btn {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            color: black;
        }
    </style>

    <div class="content-page">
        <div class="content">
            <div class="container w-100">
                @if (auth()->check() && auth()->user()->role_id == \App\Enums\UserTypes::Admin)
                    <nav aria-label="breadcrumb" class="my-2">
                        <div class="d-flex justify-content-between">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Plans</li>
                            </ol>
                            <ol class="crt-pln">
                                <a href="{{ route('plans.create') }}" class="btn theme_btn">Create New Plan</a>
                            </ol>
                        </div>
                    </nav>
                @endif

                @if (session()->has('flash_error'))
                <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                @endif
                @if (session()->has('flash_success'))
                    <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Manage Plans</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Price($)</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Price($)</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal -->
                        @foreach ($all_plans as $single_plan)
                            <div class="modal fade" id="paymentModal{{ $single_plan->id }}" tabindex="-1"
                                aria-labelledby="paymentModalLabel{{ $single_plan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel{{ $single_plan->id }}">
                                                {{ $single_plan->name }} Plan</h5>
                                            <button type="button" class="ps-btn" data-bs-dismiss="modal"
                                                aria-label="Close">&times;</button>
                                        </div>
                                        <form action="{{ route('purchase.plan') }}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="plan_id" value="{{ $single_plan->id }}" />
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Card Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required>
                                                </div>

                                                <input type="hidden" name="plan_id" value="{{ $single_plan->id }}" />
                                                <div class="mb-3">
                                                    <label for="number" class="form-label">Card Number</label>
                                                    <input type="text" class="form-control" id="number" name="number"
                                                        maxlength="16" pattern="[0-9]{16}"
                                                        title="Card number must contain exactly 16 digits" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="exp_month" class="form-label">Expiration Month</label>
                                                    <select name="exp_month"
                                                        class="form-select @error('exp_month') is-invalid @enderror">
                                                        <option value="" disabled selected>Month</option>
                                                        @for ($month = 1; $month <= 12; $month++)
                                                            <option value="{{ $month }}">
                                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                                        @endfor
                                                    </select>
                                                    @error('exp_month')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="exp_year" class="form-label">Expiration Year</label>
                                                    <select name="exp_year"
                                                        class="form-select @error('exp_year') is-invalid @enderror">
                                                        <option value="" disabled selected>Year</option>
                                                        @php
                                                            $currentYear = date('Y');
                                                        @endphp
                                                        @for ($year = $currentYear; $year <= $currentYear + 10; $year++)
                                                            <option value="{{ substr($year, -2) }}">
                                                                {{ $year }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    @error('exp_year')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="cvc" class="form-label">CVC</label>
                                                    <input type="text" class="form-control" id="cvc" name="cvc"
                                                        maxlength="3" pattern="[0-9]{3}"
                                                        title="CVC must contain exactly 3 digits" required>
                                                </div>

                                                <div class="modal-footer d-flex justify-content-between">
                                                    <button type="submit" class="ps-btn postbox-submit">Purchase</button>
                                                    <button type="button" class="ps-btn postbox-submit"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function($) {
            var userRole = {{ auth()->user()->role_id }};
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('plans.index') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        render: function(data, type, row) {
                            var editButton = '';
                            var deleteButton = '';
                            var purchaseButton = '';

                            // Check if the user role_id is 3, and if so, add the delete and edit buttons
                            if (userRole == 3) {
                                deleteButton = '<form class="delete-form" action="/plans/delete/' +
                                    row.id +
                                    '" method="POST">@csrf @method('POST')<button type="submit" class="ps-btn postbox-submit">Delete</button></form>';

                                editButton = '<a href="/plans/edit/' + row.id +
                                    '" class="plan_view_btn">Edit</a>';
                            }

                            // Check if the user role_id is 1, and if so, add the purchase button
                            if (userRole == 1) {
                                purchaseButton =
                                    '<button type="button" class="ps-btn postbox-submit subscribe_button" data-bs-toggle="modal" data-bs-target="#paymentModal' +
                                    row.id + '">Subscribe</button>';
                            }

                            var buttonHtml = '<div class="crud d-flex justify-content-center">' +
                                editButton + ' ' + deleteButton + ' ' + purchaseButton + '</div>';
                            return buttonHtml;
                        }
                    }
                ]
            });
        });
        $(document).on('click', '.close_btn', function() {
            $('.paymentModal').modal('hide');
        });
    </script>

    @if ($errors->any())
        <script>
            $(function() {
                $('#paymentModal').modal('show');
            });
        </script>
    @endif
@endsection
