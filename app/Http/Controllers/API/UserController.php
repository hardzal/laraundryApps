<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['outlet'])->orderBy('created_at', 'DESC')->courier();
        if (request()->q != '') {
            $users = $users->where('name', 'LIKE', '%' . request()->q . '%');
        }

        $users = $users->paginate(10);
        return new UserCollection($users);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|string',
            'outlet_id' => 'required|exists:outlets,id',
            'photo' => 'required|image'
        ]);

        DB::beginTransaction();

        try {
            $name = NULL;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $name = $request->email . '-' . time() . '-' . $file->getClientOriginalExtension();
                $file->storeAs('public/couriers', $name);
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'photo' => $name,
                'outlet_id' => $request->outlet_id,
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6|string',
            'outlet_id' => 'required|exists:outlets,id',
            'photo' => 'nullable|image'
        ]);

        try {
            $user = User::find($id);
            $password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $filename = $user->photo;

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                File::delete(storage_path('app/public/couriers/' . $filename));
                $filename = $request->email . '-' . time() . '-' . $file->getClientOriginalExtension();
                $file->storeAs('public/couriers', $filename);
            }

            $user->update([
                'name' => $request->name,
                'password' => $password,
                'photo' => $filename,
                'outlet_id' => $request->outlet_id
            ]);
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (\Exception $er) {
            return response()->json([
                'status' => 'error',
                'message' => $er->getMessage()
            ], 200);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        File::delete(storage_path('app/public/couriers/' . $user->photo));
        $user->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
