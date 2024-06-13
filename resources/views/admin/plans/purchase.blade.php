@extends('layouts.dashboard')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid p-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->price }}$</td>
                        <td>{{ $plan->description }}</td>
                        <td>
                            <button type="button" class="ps-btn postbox-submit" data-bs-toggle="modal"
                                data-bs-target="#paymentModal">
                                Purchase
                            </button>
                        </td>
                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="paymentModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $plan->id }}">
                                    <p><strong>Plan Name:</strong></p>
                                    <p>{{ $plan->name }}</p>
                                    <hr />
                                    <p><strong>Plan Price:</strong></p>
                                    <p>{{ $plan->price }}$</p>
                                    <hr />
                                    <div class="form-group">
                                        <label for="number">Card Number:</label>
                                        <input type="text" name="number" class="form-control" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="month">Year:</label>
                                                <select name="month" class="form-control" required>
                                                    <option selected disabled>Select Year</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="month">Month:</label>
                                                <select name="month" class="form-control" required>
                                                    <option selected disabled>Select Month</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="ps-btn postbox-submit" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="ps-btn postbox-submit">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
