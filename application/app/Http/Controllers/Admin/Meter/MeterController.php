<?php

namespace App\Http\Controllers\Admin\Meter;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Meter;
use App\Models\MeterReader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class MeterController extends Controller
{
    public function index()
    {
        $data['meters'] = Meter::latest()->paginate(10);
        return view('admin.meter.list', $data);
    }

    public function add()
    {
        $data['stuffs'] = Admin::where('is_staff', 1)->where('status', 1)->get();
        return view('admin.meter.add', $data);
    }

    public function edit($id)
    {
        $data['meter'] = Meter::where('id', $id)->first();
        $data['stuffs'] = Admin::where('is_staff', 1)->where('status', 1)->get();
        $data['meter_readers'] = MeterReader::where('meter_id', $id)->pluck('reader_id')->toArray();
        return view('admin.meter.add', $data);
    }

    public function details($id)
    {
        $data['user'] = Meter::where('id', $id)->first();
        $data['stuffs'] = User::where('is_staff', 1)->where('status', 1)->get();
        return view('admin.meter.details', $data);
    }

    public function status(Request $request)
    {
        $item = Meter::find($request->id);
        $item->status = !$item->status;
        $item->save();
        return redirect()->back()->with('message', 'Meter Status Updated Successfully!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meter_type' => 'required',
            'number' => 'required',
            'building' => 'required',
            'flat_no' => 'required',
            'customer_name' => 'required',
            'last_reading' => 'required',
            'snd' => 'required',
            'installation_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // set meter data
        $meterNewData = $request->only([
            'meter_type', 'number', 'building', 'flat_no', 'customer_name', 'address', 'last_reading',
            'last_reading_date', 'snd', 'installation_date'
        ]);

        if ($request->input('id')) {
            // Update existing meter info
            $old_data = Meter::findOrFail($request->input('id'));
            $old_data->update($meterNewData);

            /*Meter reader*/
            if($request->input('reader_id')){

                // Delete previous reader
                $previous_readers = MeterReader::where('meter_id', $old_data->id);
                if ($previous_readers->exists()) {
                    $previous_readers->delete();
                }

                // Assign new reader
                foreach ($request->reader_id as $reader_id) {
                    MeterReader::create([
                        'meter_id' => $old_data->id,
                        'reader_id' => $reader_id,
                    ]);
                }
            }

//            return redirect()->back()->with('message', 'Meter Info Updated Successfully!');
            return redirect('admin/meter/list')->with('message', 'Meter Info Updated Successfully!');
        } else {
            //check exist meter
            $exist_meter = Meter::where('number', $request->number)->first();
            if($exist_meter){
                return redirect()->back()->with('error', 'Meter Number is Already exists!');
            }
            // Create a new meter
            try {
                $meter = Meter::create($meterNewData);
                $insertedId = $meter->id;

                /*Meter reader*/
                if($request->input('reader_id')){
                    // Assign new reader
                    foreach ($request->reader_id as $reader_id) {
                        MeterReader::create([
                            'meter_id' => $insertedId,
                            'reader_id' => $reader_id,
                        ]);
                    }
                }
            } catch (Exception $e){
                Log::info($e->getMessage());
            }

            return redirect('admin/meter/list')->with('message', 'New Meter Created Successfully!');
        }

    }

    public function destroy(Request $request)
    {
        if(!empty($request->input('id'))){
            //meter delete
            Meter::where('id', $request->input('id'))->delete();
        }
        return redirect('admin/meter/list')->with('message', 'Meter Deleted Successfully!');
    }
}
