<?php

use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Wallet;
use App\Models\Setting;


function getAllCountries()
{
    return Country::get([
        "id",
        "name",
        "full_name"
    ]);
}

function getCountry($id)
{
    return Country::where('id', $id)->first();
}

function getStates($id)
{
    $country = Country::where('id', $id)->first();
    return $country->divisions()->get();
}

function getCities($id)
{
    $model = Division::where('id', $id)->first();

    return $model->children();
}

 function sendPushNotification($user, $title, $message, $responsedata, $user_type)
{
    if (!$user->fcm_token) {
        return ['success' => false, 'error' => 'User does not have an FCM token'];
    }

    $data = json_encode([
        'to' => $user->fcm_token,
        'notification' => [
            'title' => $title,
            'body' => $message,
        ],
        'data' => $responsedata,
    ]);

    $url = 'https://fcm.googleapis.com/fcm/send';
    $fcm_key = 'AAAAjw7PUrQ:APA91bFlc2OzvEeejyZtELNk4DqCyjiCjgux0O8rCNzQi5RscP4U1HF_Z3YqmVsw7s6TyXys0bvkiHfHtKsSM6n7W6RKXpPQMprvqlv6WRsN-EroOU_RvwJPn2QpYTASHDdYO-g9xQ-a';

    $headers = [
        'Content-Type: application/json',
        'Authorization: key=' . $fcm_key,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);

    if ($result === false) {
        return ['success' => false, 'error' => curl_error($ch)];
    }

    $resultResponse = json_decode($result);
    curl_close($ch);

    if (isset($resultResponse->error)) {
        return ['success' => false, 'error' => $resultResponse->error];
    }

    return ['success' => true, 'response' => $resultResponse];
}
function getPlans()
{
    $models = Plan::get([
        "id",
        "name",
        "slug",
        "stripe_plan",
        "price",
        "description",
        "feature_count"
    ]);

    return $models;
}

function getServices()
{
    $models = Service::get([
        "id",
        "name",
        "description",
        "status",
    ]);

    return $models;
}

function getLeadPrice()
{
    $lead_price = 10;

    $lead_setting = Setting::where('key', 'lead_price')->first();

    return $lead_setting ? $lead_setting->value : $lead_price;
}

function checkIfUserCanBuyLead($user)
{
    $userBalances = getUserBalances($user);
    $userBalance = $userBalances["total"] - $userBalances["usage"];

    return $userBalance >= getLeadPrice();
}

// function topUpWallet($user_id, $payment_id, $amount)
// {
//     $wallet = new Wallet();
//     $wallet->user_id = $user_id;
//     $wallet->payment_id = $payment_id;
//     $wallet->amount = $amount;
//     $wallet->used = 0;
//     $wallet->save();

//     return $wallet;
// }

function chargeWalletForLead($user_id, $lead_id)
{
    $wallet = new Wallet();
    $wallet->user_id = $user_id;
    $wallet->lead_id = $lead_id;
    $wallet->amount = getLeadPrice();
    $wallet->used = 1;
    $wallet->save();

    return $wallet;
}
