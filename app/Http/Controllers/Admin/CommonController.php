<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function getStates(Request $request)
    {
        $country_id = $request->country_id;

        $data = getStates($country_id);

        return $data;
    }



    public function getCities(Request $request)
    {
        $state_id = $request->state_id;

        $data = getCities($state_id);

        return $data;
    }
}
