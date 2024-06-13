<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PlansController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id !== null) {
            $plan = Plan::findOrFail($id);
            return view('admin.plans.index', compact('plan'));
        }

        if ($request->ajax()) {
            $plans = Plan::all();
            return DataTables::of($plans)
                ->addIndexColumn()
                ->addColumn('name', function (Plan $plan) {
                    return $plan->name;
                })
                ->addColumn('slug', function (Plan $plan) {
                    return $plan->slug;
                })
                ->addColumn('price', function (Plan $plan) {
                    return $plan->price;
                })
                ->addColumn('created_at', function (Plan $plan) {
                    return $plan->created_at;
                })
                ->make(true);
        }
        $all_plans = Plan::get();
        return view('admin.plans.index', compact('all_plans'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'string', 'unique:plans'],
                'slug' => ['nullable', 'string', 'unique:plans'],
                'feature_count' => ['nullable', 'numeric'],
                'price' => ['required', 'numeric'],
                'recurring' => 'required',
            ]);

            $plan = new Plan();
            $plan->name = $request->name;
            $plan->slug = $request->slug;
            $plan->stripe_plan = $request->slug;
            $plan->price = $request->price;
            $plan->recurring = $request->recurring;
            $plan->currency = $request->currency;
            $plan->description = $request->description;
            $plan->feature_count = $request->feature_count;

            if ($plan->save()) {
                $stripe = new \Stripe\StripeClient('sk_test_51J8ROIFyJKeHlHtSctFzqEuHniCT9mjHKR774MZtpNBu2V07cnqBdHpyhAWgO5ZVvHFWeUGiygTeOwKQBI9WcIJc00fjPD0PCR');
                $product_detail = $stripe->products->create([
                    'name' => $request->name,
                ]);
                $product_id = $product_detail->id;
                $plan_price = $stripe->prices->create([
                    'unit_amount' => $request->price * 100,
                    'currency' => $request->currency,
                    'recurring' => ['interval' => $request->recurring], // it defines the recurring interval
                    'product' => $product_id,
                ]);
                $plan->price_id = $plan_price->id;
                $plan->save();
                return Redirect::back()->with(['flash_success' => "Congratulations!, Plan has been created."]);
            }
            return Redirect::back()->with(['flash_error' => "Oops!, Something went wrong."]);
        }
        return view('admin.plans.create');
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);
        $user = Auth::user();
        if (!$plan) {
            return Redirect::back()->with(['flash_error' => "Oops!, Invalid Plan."]);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'mode' => 'required',
                'name' => ['required', 'string'],
                'slug' => ['nullable', 'string'],
                'feature_count' => ['nullable', 'numeric'],
                'price' => ['required', 'numeric'],
                'recurring' => 'required',
            ]);
            if ($request->mode && $plan->mode !== $request->mode) {
                $plan->mode = $request->mode;
            }
            if ($request->name && $plan->name !== $request->name) {
                $plan->name = $request->name;
            }
            if ($request->slug && $plan->slug !== $request->slug) {
                $plan->slug = $request->slug;
                $plan->stripe_plan = $request->slug;
            }
            if ($request->price && $plan->price !== $request->price) {
                $plan->price = $request->price;
            }
            if ($request->recurring && $plan->recurring !== $request->recurring) {
                $plan->recurring = $request->recurring;
            }
            if ($request->currency && $plan->currency !== $request->currency) {
                $plan->currency = $request->currency;
            }
            if ($request->description && $plan->description !== $request->description) {
                $plan->description = $request->description;
            }
            if ($request->feature_count && $plan->feature_count !== $request->feature_count) {
                $plan->feature_count = $request->feature_count;
            }
            if ($plan->save()) {
                return Redirect::back()->with(['flash_success' => "Congratulations!, Plan has been updated."]);
            }
            return Redirect::back()->with(['flash_error' => "Oops!, Something went wrong."]);
        }
        return view('admin.plans.edit', ["plan" => $plan]);
    }


    public function planDetails($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.purchase', compact('plan'));
    }

    public function delete($id)
    {
        Plan::findOrFail($id)->delete();
        return redirect()->route('plans.index')->with('flash_success', 'Plan has been deleted successfully');
    }
}
