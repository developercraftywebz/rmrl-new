<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionsController extends Controller
{
    public function index(Request $request)
    {
        $subscription = Subscription::with('Plan')->get();
        if ($request->ajax()) {
            return DataTables::of($subscription)
                ->addIndexColumn()
                ->addColumn('created_at', function (Subscription $subscription) {
                    return $subscription->getCreatedAtForHumans();
                })
                ->addColumn('user_name', function (Subscription $subscription) {
                    return $subscription->User->first_name . ' ' . $subscription->User->last_name;
                })
                ->addColumn('plan_name', function (Subscription $subscription) {
                    return $subscription->Plan->name;
                })
                ->addColumn('amount', function (Subscription $subscription) {
                    return $subscription->Plan->price;
                })
                ->addColumn('view', function (Subscription $subscription) {
                    return $subscription->id; // Assuming Subscription has an 'id' property
                })
                ->addColumn('delete', function (Subscription $subscription) {
                    return $subscription->id; // Assuming Subscription has an 'id' property
                })
                ->make(true);
        }
        return view('admin.subscriptions.index');
    }
}
