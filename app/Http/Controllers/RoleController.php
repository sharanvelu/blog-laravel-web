<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * @return bool
     */
    private function checkPermission() {
        abort_unless(Auth::check(), 404);
        abort_unless(Auth::user()->hasAnyRole(['SuperAdmin','Admin']), 404);
        return true;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list() {
        $this->checkPermission();
        return view('roles.list');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $this->checkPermission();
        return view('roles.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assign() {
        $this->checkPermission();
        return view('roles.assign');
    }

    /**
     * @param $role_name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($role_name) {
        $this->checkPermission();
        return view('roles.update', [
            'role' => Role::where('name', $role_name)->first()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add()
    {
        $role = Role::create(['name' => $_POST['role_name']]);

        $permissions = array();
        foreach (Permission::all() as $permission) {
            array_push($permissions, $permission->name);
        }
        foreach ($_POST as $entry) {
            if(in_array($entry, $permissions)) {
                $role->givePermissionTo($entry);
            }
        }

        //Browser Redirection to role lis page
        return redirect('role/list');
    }

    /**
     * @param $role_name
     */
    public function deleteRole($role_name)
    {
        Role::where('name', $role_name)->firstOrFail()->delete();
    }

    /**
     * @param $action
     * @return string
     */
    public function userRoleAssignDetach($action)
    {
        $user = User::where('name', $_POST['user_name'])->first();
        $role = Role::where('name', $_POST['role_name'])->first();
        if($action == 'assign') {
            $user->assignRole($role);
            return 'Assigned';
        } elseif($action == 'detach') {
            $user->removeRole($role);
            return 'Removed';
        } elseif ($action == 'sync') {
            $user->syncRoles([$role]);
        }
    }

    /**
     * @param $role_name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function change($role_name)
    {
        $role = Role::where('name',$role_name)->firstOrFail();

        $permissions = array();
        $sync_permission = array();
        foreach (Permission::all() as $permission) {
            array_push($permissions, $permission->name);
        }

        foreach ($_POST as $entry) {
            if(in_array($entry, $permissions)) {
                array_push($sync_permission, $entry);
            }
        }
        $role->syncPermissions($sync_permission);


        //Browser Redirection to role lis page
        return redirect('role/list');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function roleListTable()
    {
        $data = Role::all();
        return Datatables::of($data)
            ->addColumn('count', function ($data) {
                return $data->permissions->count();
            })
            ->addColumn('action', function ($data) {
                if (strtolower($data->name) == 'superadmin') {
                    $button = " ---------- ";
                } elseif (Auth::user()->hasRole('Admin') && $data->name == 'Admin'){
                    $button = " ---------- ";
                } else {
                    $button = '<a href="\\role/update/'.$data->name.'">
                                <span class="mr-1 custom-button-primary">
                                <i class="fas fa-fw fa-edit"></i></span></a>';
                    $button .= '<a type="button" onclick="deleteRole( \'' . $data->name . '\', this.form)" >
                                <span class="custom-button-danger">
                                <i class="fas fa-fw fa-trash-alt"></i></span></a>';
                }
                return $button;
            })->make(true);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function userRoleListTable()
    {
        $user_role = array();
        $users = User::all();
        $roles = Role::all();
        /////*mhrs -> model_has_roles*/
        $mhrs = DB::table('model_has_roles')->get();
        foreach ($mhrs as $mhr) {
            array_push($user_role, [
                'user_name' => $users->find($mhr->model_id)->name,
                'role' => $roles->find($mhr->role_id)->name,
            ]);
        }
        return Datatables::of($user_role)
            ->addcolumn('user_name', function ($user_role) {
                return $user_role['user_name'];
            })
            ->addcolumn('role', function ($user_role) {
                return $user_role['role'];
            })
            ->addColumn('action', function ($user_role) {
                if (strtolower($user_role['role']) == 'superadmin') {
                    $button = " ----- ";
                } elseif (Auth::user()->hasRole('Admin') && $user_role['role'] == 'Admin'){
                    $button = " ----- ";
                } else {
                    $button = '<a class="custom-button-success mr-1" href="#"
                                onclick="event.preventDefault(); updateUserRole(\''.$user_role['user_name'].'\')">
                                <i class="fas fa-fw fa-edit"></i>
                                </a>';
                    $button .= '<button class="custom-button-danger mr-1" type="button"
                                onclick="assignDetachRole(this.form, \'detach\',\'' .$user_role['user_name']. '\', \'' . $user_role['role']. '\')" >
                                <i class="fas fa-fw fa-trash-alt"></i></button>';
                }
                return $button;
            })->make(true);
    }
}
