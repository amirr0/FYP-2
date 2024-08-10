<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserBasicInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $roles = Role::all();
        $query = User::whereNot('id', Auth::user()->id)->with('role');

        // Filtering based on role
        if ($request->has('role') && $request->role !== null) {
            $query->where('role_id', $request->role);
        }

        // Filtering based on status
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Include trashed users
        if ($request->has('trashed') && $request->trashed == true) {
            $query->onlyTrashed();
        }

        $users = $query->where('role_id', '!=', 1)->get();
        $totalUsersCount = User::where('role_id', '!=', 1)->count();
        $activeUsersCount = User::where('status', 'Active')->count();
        // Count inactive users excluding the currently authenticated user
        $inactiveUsersCount = User::where('status', 'Inactive')
            ->where('role_id', '!=', 1)
            ->count();

        // Count trashed users excluding the currently authenticated user
        $trashedUsersCount = User::onlyTrashed()
            ->where('role_id', '!=', 1)
            ->count();

        return view('modules.users.index', compact('roles', 'users', 'totalUsersCount', 'activeUsersCount', 'inactiveUsersCount', 'trashedUsersCount'));
    }

    public function create()
    {
    }

    public function store(UserRequest $request)
    {
        try {

            DB::beginTransaction();

            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile_pictures'), $imageName);
                $profilePicturePath = 'profile_pictures/' . $imageName;
            }

            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $request->input('role_id'),
                'status' => $request->input('status'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'profile_picture' => $profilePicturePath,
            ]);

            DB::commit();

            return redirect()->route('backend.users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to create users. Please try again.' . $e->getMessage());
        }
    }

    public function show(User $user)
    {

        return view('modules.users.view', compact('user'));
    }

    public function edit(User $user)
    {
        // $user->load('basic_info');
        return view('modules.users.edit', compact('user'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $userData = [
                'email' => $request->input('email'),
                'status' => $request->input('status'),
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->input('password'));
            }

            $user->update($userData);

            $basicInfoData = [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'dob' => Carbon::parse($request->input('dob'))->format('Y-m-d'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ];

            if ($request->hasFile('profile_picture')) {
                $userImage = $user->basic_info->profile_picture;
                if ($userImage) {
                    $imagePath = public_path($userImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $image = $request->file('profile_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile_pictures'), $imageName);
                $profilePicturePath = 'profile_pictures/' . $imageName;
                $basicInfoData['profile_picture'] = $profilePicturePath;
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to update users. Please try again.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return back()->with('success', 'User has been deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete users. Please try again.');
        }
    }

    public function updateStatus(Request $request, User $user)
    {
        try {
            $status = $request->input('status');
            $user->update(['status' => $status]);
            return back()->with('success', 'User status updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update user status. Please try again.');
        }
    }

    public function userPermanentDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('users.index')->with('success', 'User permanently deleted.');
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'User restored successfully.');
    }
}
