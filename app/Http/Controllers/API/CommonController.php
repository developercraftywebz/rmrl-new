<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getCountries($id = null)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => $id ? getCountry($id) : getAllCountries()
        ];

        return response()->json($response, 200);
    }


    public function getStates($id)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => getStates($id)
        ];

        return response()->json($response, 200);
    }

    public function getcities($id)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => getCities($id)
        ];

        return response()->json($response, 200);
    }

    public function termsAndCondition()
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => [
                "terms" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            ]
        ];
        return response()->json($response, 200);
    }


    public function privacyPolicy()
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => [
                "policy" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            ]
        ];
        return response()->json($response, 200);
    }
}
