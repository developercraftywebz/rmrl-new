<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'admin_email' => ['required', 'email']
            ]);

            foreach ($request->all() as $key => $item) {
                if ($key == "_token") continue;

                $setting = Setting::where('key', $key)->first();

                if ($setting == null) {
                    $setting = new Setting();
                    $setting->key = $key;
                }

                $setting->value = $item;
                $setting->save();
            }

            return Redirect::back()->with(['flash_success' => "Congratulations!, Settings are updated."]);
        }

        $admin_email = Setting::where('key', 'admin_email')->first();

        return view('admin.settings.index', [
            "admin_email" => $admin_email ? $admin_email->value : null,
        ]);
    }
}
