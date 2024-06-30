<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Block;
use App\Models\District;
use App\Models\FileManager;
use App\Models\Road;
use App\Models\Thana;
use App\Models\Union;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $userQuery = User::latest()->with('media');

        if ($request->has('is_staff')) {
            $isStaff = $request->query('is_staff');

            if ($isStaff === "0" || $isStaff === "1") {
                $userQuery->where('is_staff', $isStaff);
            }
        }

        $users = $userQuery->get();

        $adminQuery = Admin::latest();

        if ($request->has('is_staff')) {
            if ($isStaff === "0" || $isStaff === "1") {
                $adminQuery->where('is_staff', $isStaff);
            }
        }

        $admins = $adminQuery->get();

        $mergedResults = $users->merge($admins);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentResults = $mergedResults->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedResults = new LengthAwarePaginator($currentResults, $mergedResults->count(), $perPage);
        $paginatedResults->setPath($request->url());

        $data['users'] = $paginatedResults;

        return view('admin.user.list', $data);
    }



    public function add()
    {
        $data['roads'] = Road::get();
        $data['blocks'] = Block::get();
        return view('admin.user.add', $data);
    }

    public function edit($id)
    {
        $data['user'] = Admin::where('id', $id)->first();
        return view('admin.user.add', $data);
    }

    public function details($id)
    {
        $data['user'] = User::where('id', $id)->with('fileManager')->withCount('property', 'UnitHolder')->first();
        $data['media'] = $data['user']->getMedia()->where('model_id', $id)->where('model_type', 'App\Models\User');
        return view('admin.user.details', $data);
    }

    public function status(Request $request)
    {
        $item = User::find($request->id);
        $item->is_active = !$item->is_active;
        $item->save();
        return redirect()->back()->with('message', 'User Status Updated Successfully!');
    }

    public function store(Request $request, User $user)
    {
        $rules = [
            'name' => 'required',
            'plot_no' => 'required',
            'block_id' => 'required',
            'road_id' => 'required',
            'nid' => 'required|numeric'
        ];

        if ($request->input('id')) {
            $rules['phone_number'] = 'required';
            $rules['email'] = 'required';
        } else {
            $rules['phone_number'] = "required|unique:users,phone_number,{$user->id}";
            $rules['email'] = "required|unique:users,email,{$user->id}";
            $rules['password'] = [
                'required',
                Password::min(6),
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // user data
        $userNewData = $request->only([
            'phone_number', 'password', 'name', 'email', 'age', 'nid',
            'passport', 'father_name', 'mother_name', 'plot_no', 'block_id', 'road_id',
            'building_name'
        ]);
        if ($request->has('password')) {
            $userNewData['password'] = Hash::make($request->input('password'));
        }

        if ($request->input('id')) {
            // Update existing user
            $old_user = User::findOrFail($request->input('id'));
            $old_user->update($userNewData);

            if (isset($request->image)) {
                $old_user->clearMediaCollection();

                $old_user->addMedia($request->file('image'))->toMediaCollection('avatar');

//                $old_user
//                    ->addMedia($request->image)
//                    ->toMediaCollection();
//                $file_manager = FileManager::whereOriginId($old_user->id)->where('origin_type', User::class)->first();
//                if (!$file_manager) {
//                    $file_manager = (new FileManager())->upload('photos/user', $request->image);
//                    if ($file_manager->id != 0) {
//                        $file_manager->origin()->associate($file_manager)->save();
//                    }
////                    $file_manager->origin()->associate($file_manager)->save();
//                }

//                if ($old_user->fileManager) {
//                    $file_manager->uploadUpdate('photos/user', $request->image);
//                }
            }

            return redirect()->back()->with('message', 'User Updated Successfully!');
        } else {
            // Create a new user and associated EmergencyContact
            $user = User::create($userNewData);

            if (isset($request->image)) {

                $user->addMedia($request->file('image'))->toMediaCollection('avatar');

//                $user
//                    ->addMedia($request->image)
//                    ->toMediaCollection();

//                $file_manager = (new FileManager())->upload('images/users', $request->image);
//                if ($file_manager->id != 0) {
//                    $file_manager->origin()->associate($user)->save();
//                }
            }
            return redirect('admin/user/list')->with('message', 'User Added Successfully!');
        }

    }

    public function storeAdmin(Request $request)
    {
        // Initialize admin variable
        $admin = $request->id ? Admin::find($request->id) : new Admin;

        $rules = [
            'is_staff' => 'required|boolean',
            'name' => 'required|string|max:255',
            'password' => $request->id ? 'nullable|min:6' : 'required|min:6',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id)
            ],
            'phone' => [
                'required',
                Rule::unique('admins')->ignore($admin->id)
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Set the admin properties
        $admin->is_staff = $request->is_staff;
        $admin->name = $request->name;
        $admin->user_name = $request->user_name;

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        $admin->email = $request->email;
        $admin->phone = $request->phone;

        $admin->save();

        // Redirect with a success message
        return redirect('admin/user/list')->with('message', $request->id ? 'Staff Updated Successfully!' : 'Staff Created Successfully!');
    }


    public function destroy(Request $request)
    {
        if(!empty($request->input('id'))){
            //property delete
            Property::where('user_id', $request->input('id'))->delete();
            //unit delete
            Unit::where('user_id', $request->input('id'))->delete();
            //user delete
            User::where('id', $request->input('id'))->delete();

        }
        return redirect('admin/user/list')->with('message', 'User all Assets Deleted Successfully!');
    }

    public function getDistricts()
    {
        $districts = District::all();
        return response()->json($districts);
    }

    public function getThanas(Request $request)
    {
        if($request->district_id){
            $thanas = Thana::where('district_id', $request->district_id)->get();
        } else {
            $thanas = Thana::latest()->get();
        }
        return response()->json($thanas);
    }

    public function getUnions(Request $request)
    {
        if($request->thana_id){
            $unions = Union::where('thana_id', $request->thana_id)->get();
        } else {
            $unions = Union::latest()->get();
        }
        return response()->json($unions);
    }
}
