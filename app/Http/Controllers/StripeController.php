<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    protected $stripe = null;
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function createCardToken($card)
    {
        $response = $this->stripe->tokens->create([
            'card' => $card,
        ]);

        return $response;
    }

    public function createCustomer($email, $token)
    {
        $customer = $this->stripe->customers->create(array(
            "email" => $email,
            "source" => $token->id
        ));

        return $customer;
    }

    public function chargeCustomer($customer, $amount)
    {
        $charge = $this->stripe->charges->create(array(
            "amount" => $amount,
            "currency" => "usd",
            "customer" => $customer->id,
        ));

        return $charge;
    }
}
