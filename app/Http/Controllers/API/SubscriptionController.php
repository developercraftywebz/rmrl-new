<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripeController;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Plan;
use App\Models\UserCard;
use Laravel\Passport\Passport;

class SubscriptionController extends Controller
{
    public function getPlans(Request $request)
    {
        $user = $request->user();
        $plans = Plan::get();
        if ($request->expectsJson()) {
            $response = [
                'status' => 200,
                'message' => "",
                'data' => [
                    "plans" => Plan::get(),
                    'user' => $user->getUserDisplayFields()
                ]
            ];
            return response()->json($response, 200);
        } else {
            return view('admin.plans.index', ['plans' => $plans]);
        }
    }

    public function purchasePlan(Request $request)
    {
        try {
            $user = $request->user();
            $plan = Plan::where('id', $request->plan_id)->first();
            $subscription = $user->subscription($plan->name);
            // Cannot buy the same plan
            if ($user->subscribed($plan->name)) {
                if ($request->expectsJson()) {
                    throw new \ErrorException('You already have an active subscription.');
                } else {
                    return redirect()->back()->with('flash_error', 'You already have an active subscription.');
                }
            }
            // Plan upgrade
            if ($subscription && !$subscription->isActive()) {
                if ($request->expectsJson()) {
                    throw new \ErrorException('You have successfully upgraded your plan.');
                } else {
                    return redirect()->back()->with('flash_error', 'You have successfully upgraded your plan.');
                }
            }
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|numeric',
                'number' => 'required|digits:16',
                'exp_month' => 'required|integer|min:1|max:12',
                'exp_year' => 'required|digits:2|integer|min:' . date('y') . '|max:' . (date('y') + 10),
                'cvc' => 'required|digits:3'
            ]);

            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    throw new \ErrorException($validator->errors()->first());
                } else {
                    return redirect()->back()->with('flash_error', $validator->errors()->first());
                }
            }
            if ($plan == null) {
                throw new \ErrorException('Invalid plan');
            }
            $user->createOrGetStripeCustomer();
            $user->createSetupIntent();
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethods = $user->addPaymentMethod($paymentMethods);
            $user->newSubscription(
                $plan->name,
                $plan->price_id
            )->create($paymentMethods->id);
            // //update feature count in user account
            // $user->feature_count += $plan->feature_count;
            $user->save();

            $card = UserCard::where('user_id', $request->user()->id)->where('number', $request->number)->first();

            if ($card == null) {
                $card = new UserCard();
                $card->user_id = $request->user()->id;
            }

            $card->name = $request->name;
            $card->number = $request->number;
            $card->exp_month = $request->exp_month;
            $card->exp_year = $request->exp_year;
            $card->cvc = $request->cvc;
            $card->save();

            $stripe = new StripeController();
            $expMonth = intval($request->exp_month);
            $expYear = intval($request->exp_year);
            $token = $stripe->createCardToken([
                'number' => $request->number,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'cvc' => $request->cvc,
            ]);

            // Record Payment
            $payment = new Payment();
            $payment->user_id = $request->user()->id;
            $payment->amount = $plan->price;
            $payment->plan_id = $plan->id;
            $payment->token_response = json_encode($token);
            $payment->created_at = date('Y-m-d H:i:s');
            $payment->updated_at = date('Y-m-d H:i:s');
            $payment->save();

            if ($request->expectsJson()) {
                $response = [
                    'status' => 200,
                    'message' => "Congratulations!, Plan purchased successfully",
                    'data' => [
                        'user' => $user->getUserDisplayFields(),
                    ]
                ];
                return response()->json($response, 200);
            } else {
                return redirect()->route('plans.index')->with('flash_success', "You have successfully purchased" . " $plan->name " . "plan");
            }
        } catch (\Exception $e) {

            if ($request->expectsJson()) {
                return redirect()->route('plans.index')->with('flash_error', 'There seems to be an error, kindly try again later');
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => $e->getMessage(),
                ], 422);
            }
        }
    }


    public function purchasePlanApi(Request $request)
    {
        try {
            $user = $request->user();
            $plan = Plan::where('id', $request->plan_id)->first();
            $subscription = $user->subscription($plan->name);
    
            if ($user->subscribed($plan->name)) {
                throw new \ErrorException('You already have an active subscription.');
            }
    
            if ($subscription && !$subscription->isActive()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'You have successfully upgraded your plan.',
                    'data' => [
                        'user' => $user->getUserDisplayFields(),
                        'subscription' => $subscription, // Include subscription in the response
                    ],
                ], 200);
            }
    
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|numeric',
                'number' => 'required|digits:16',
                'exp_month' => 'required|integer|min:1|max:12',
                'exp_year' => 'required|digits:2|integer|min:' . date('y') . '|max:' . (date('y') + 10),
                'cvc' => 'required|digits:3',
            ]);
    
            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }
    
            if ($plan == null) {
                throw new \ErrorException('Invalid plan');
            }
    
            $user->createOrGetStripeCustomer();
            $user->createSetupIntent();
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethods = $user->addPaymentMethod($paymentMethods);
            $newSubscription = $user->newSubscription(
                $plan->name,
                $plan->price_id
            )->create($paymentMethods->id);
    
            $user->save();
    
            $card = UserCard::where('user_id', $request->user()->id)->where('number', $request->number)->first();
    
            if ($card == null) {
                $card = new UserCard();
                $card->user_id = $request->user()->id;
            }
    
            $card->name = $request->name;
            $card->number = $request->number;
            $card->exp_month = $request->exp_month;
            $card->exp_year = $request->exp_year;
            $card->cvc = $request->cvc;
            $card->save();
    
            $stripe = new StripeController();
            $expMonth = intval($request->exp_month);
            $expYear = intval($request->exp_year);
            $token = $stripe->createCardToken([
                'number' => $request->number,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'cvc' => $request->cvc,
            ]);
    
            $payment = new Payment();
            $payment->user_id = $request->user()->id;
            $payment->amount = $plan->price;
            $payment->plan_id = $plan->id;
            $payment->token_response = json_encode($token);
            $payment->created_at = now();
            $payment->updated_at = now();
            $payment->save();
    
            $accessToken = $user->createToken(Passport::client()->name)->accessToken;
    
            $response = [
                'status' => 200,
                'message' => "Congratulations! Plan purchased successfully",
                'data' => [
                    'access_token' => $accessToken,
                    'user' => $user->getUserDisplayFields(),
                ],
                'subscription' => $newSubscription, // Include new subscription at the same level as 'data'
            ];
            
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 422);
        }
    }

    public function cancelPlan(Request $request, Plan $plan)
    {
        $user = $request->user();
        $user->subscription($plan->name)->cancel();
        $response = [
            'status' => 200,
            'message' => "Subscription cancelled successfully",
            'data' => [
                "user" => $user->getUserDisplayFields(),
            ]
        ];
        return response()->json($response, 200);
    }
}
