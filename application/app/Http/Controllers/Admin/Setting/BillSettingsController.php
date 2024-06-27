<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Settings\BillSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillSettingsController extends Controller
{

    public function list()
    {
        $data['settings'] = BillSetting::get();
        return view('admin.setting.bill.list', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'value' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Check if the type already exists
        $check_exist = BillSetting::where('type', $request->type)->first();
        if ($check_exist) {
            // Return an error message if the type already exists
            return redirect()->back()->with('error', 'Type is already exists!');
        }

        $billSetting = new BillSetting();
        $billSetting->type = $request->type;
        $billSetting->value = $request->value;
        $billSetting->status = $request->status ?? 1;
        $billSetting->save();

        return redirect()->back()->with('message', 'Type is successfully added!');
    }

    public function update(Request $request)
    {
        $data = $request->all();

        foreach ($data as $id => $values) {
            // Find the BillSetting record by ID
            $billSetting = BillSetting::find($id);

            if ($billSetting) {
                // Update the type and value
                $billSetting->type = $values['type'];
                $billSetting->value = $values['value'];
                $billSetting->save();
            }
        }

        return redirect()->back()->with('message', 'Bill Settings Updated Successfully!');
    }

}
