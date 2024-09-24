<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\LoginDetail;
use App\Models\NOC;
use App\Models\User;
use App\Models\UserCompany;
use Auth;
use File;
use Illuminate\Support\Facades\Crypt;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UserToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Facades\Gate;
use App\ApiMessage;
use App\ApiCode;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage user')) {



            $query = User::with('roles');  // Include roles in the query

            if (!empty($request->status)) {
                $query->where('status', '=', (int) $request->status);
            }

            if ($request->ajax()) {
                return DataTables::of($query)

                ->addColumn('role', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('status_badge', function ($user) {
                    $status = $user->is_active > 0 ? 'bg-danger' : 'bg-success';
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                        . __($user->status ? 'Active' : 'Deactivate') . '</span>';
                })
                ->addColumn('actions', function ($user) {
                    $actions = '';

                    // Show user
                    // if (Gate::check('show user')) {
                    //     $actions .= '<div class="action-btn bg-info ms-2">
                    //                     <a href="' . route('users.show', $user->id) . '"
                    //                         class="mx-3 btn btn-sm align-items-center"
                    //                         data-bs-toggle="tooltip" title="' . __('Show') . '"
                    //                         data-original-title="' . __('Detail') . '">
                    //                         <i class="ti ti-eye text-white"></i>
                    //                     </a>
                    //                 </div>';
                    // }

                    // Edit user
                    if (Gate::check('edit user')) {
                        $actions .= '<div class="action-btn bg-primary ms-2 dialihkan_ke" data-id="'. $user->id .'" >
                                        <a  href="#" data-url="' . route('users.edit', $user->id) . '"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-size="lg"
                                            data-ajax-popup="true"
                                            data-bs-toggle="tooltip" title="' . __('Edit') . '"
                                            data-original-title="' . __('Edit') . '">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>';
                    }

                    // Delete user
                    if (Auth::user()->can('delete user')) {
                        $actions .= '<div class="action-btn bg-danger ms-2">
                                       <a href="#" data-id="'.$user->id.'"
                                                class="mx-3 btn btn-sm btn-delete align-items-center"
                                                data-bs-toggle="tooltip"
                                                title="' . __('Delete') . '"
                                                data-original-title="' . __('Delete') . '"
                                                data-confirm="' . __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') . '"
                                                data-confirm-yes="document.getElementById(\'delete-form-' . $user->id . '\').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                    </div>';
                    }

                    return $actions;
                })
                ->rawColumns([ 'status_badge', 'actions'])
                ->make(true);



            }

            return view('user.index');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create()
    {


        $user  = \Auth::user();
        $roles = Role::get()->pluck('name', 'id')->toArray();

        $pendampingUkur = User::whereHas('roles', function ($query) {
            $query->where('name', 'Pembantu Ukur');
        })->pluck('name', 'id');

        // return $roles;
        return view('user.create', compact('roles', 'pendampingUkur'));

    }

    public function store(Request $request)
    {

        if (\Auth::user()->can('manage user')) {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();


            $validator = \Validator::make(
                $request->all(),
                [
                                   'name' => 'required|max:120',
                                   'email' => 'required|email|unique:users',
                                   'password' => 'required|min:6',
                                    'role' => 'required|exists:roles,id',
                               ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $role_r = Role::findById($request->role);
            $user               = new User();
            $user['name']       = $request->name;
            $user['email']      = $request->email;
            $psw                = $request->password;
            $user['password']   = Hash::make($request->password);
            $user['lang']       = !empty($default_language) ? $default_language->value : 'en';
            $user['created_by'] = \Auth::user()->id;
            $user['email_verified_at'] = date('Y-m-d H:i:s');
            $user['pembantu_ukur']   = null;
            if ($role_r->name == "Petugas Ukur") {
                $user['pembantu_ukur']       = $request->pembantu_ukur;
            }

            $user->save();
            $role_r = Role::findById($request->role);
            $user->assignRole($role_r);

            return redirect()->route('users.index')->with('success', __('User successfully created.'));

        } else {
            return redirect()->back();
        }

    }
    public function show()
    {
        return redirect()->route('user.index');
    }

    public function edit($id)
    {

        if (\Auth::user()->can('edit user')) {
            $user              = User::findOrFail($id);
            $roles = Role::get();

            return view('user.edit', compact('user', 'roles'));
        } else {
            return redirect()->back();
        }

    }


    public function update(Request $request, $id)
    {

        if (\Auth::user()->can('edit user')) {

            $user = User::findOrFail($id);
            $validator = \Validator::make(
                $request->all(),
                [
                                   'name' => 'required|max:120',
                                   'email' => 'required|email|unique:users,email,' . $id,
                               ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $role = Role::findById($request->role);
            $input = $request->all();


            if ($role->name == "Petugas Ukur") {
                $user['pembantu_ukur']       = $request->pembantu_ukur;
            }
            $user->fill($input)->update();

            $user->roles()->sync($request->role);

            return redirect()->route('users.index')->with(
                'success',
                'User successfully updated.'
            );

        } else {
            return redirect()->back();
        }
    }


    public function destroy($id)
    {

        if (\Auth::user()->can('delete user')) {
            $user = User::find($id);
            $user->delete();

            return $this->respond(null, ApiMessage::SUCCESFULL_DELETE);
        } else {
            return redirect()->back();
        }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

        return view('user.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);
        $this->validate(
            $request,
            [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                    ]
        );
        if ($request->hasFile('profile')) {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $settings = Utility::getStorageSetting();
            if ($settings['storage_setting'] == 'local') {
                $dir        = 'uploads/avatar/';
            } else {
                $dir        = 'uploads/avatar';
            }

            $image_path = $dir . $userDetail['avatar'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }


            $url = '';
            $path = Utility::upload_file($request, 'profile', $fileNameToStore, $dir, []);
            if ($path['flag'] == 1) {
                $url = $path['url'];
            } else {
                return redirect()->route('profile', \Auth::user()->id)->with('error', __($path['msg']));
            }

            //            $dir        = storage_path('uploads/avatar/');
            //            $image_path = $dir . $userDetail['avatar'];
            //
            //            if(File::exists($image_path))
            //            {
            //                File::delete($image_path);
            //            }
            //
            //            if(!file_exists($dir))
            //            {
            //                mkdir($dir, 0777, true);
            //            }
            //            $path = $request->file('profile')->storeAs('uploads/avatar/', $fileNameToStore);

        }

        if (!empty($request->profile)) {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();
        CustomField::saveData($user, $request->customField);

        return redirect()->route('dashboard')->with(
            'success',
            'Profile successfully updated.'
        );
    }

    public function updatePassword(Request $request)
    {

        if (Auth::Check()) {
            $request->validate(
                [
                    'old_password' => 'required',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );
            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;
            if (Hash::check($request_data['old_password'], $current_password)) {
                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);
                ;
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            } else {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        } else {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }
    // User To do module
    public function todo_store(Request $request)
    {
        $request->validate(
            ['title' => 'required|max:120']
        );

        $post            = $request->all();
        $post['user_id'] = Auth::user()->id;
        $todo            = UserToDo::create($post);


        $todo->updateUrl = route(
            'todo.update',
            [
                             $todo->id,
                         ]
        );
        $todo->deleteUrl = route(
            'todo.destroy',
            [
                              $todo->id,
                          ]
        );

        return $todo->toJson();
    }

    public function todo_update($todo_id)
    {
        $user_todo = UserToDo::find($todo_id);
        if ($user_todo->is_complete == 0) {
            $user_todo->is_complete = 1;
        } else {
            $user_todo->is_complete = 0;
        }
        $user_todo->save();
        return $user_todo->toJson();
    }

    public function todo_destroy($id)
    {
        $todo = UserToDo::find($id);
        $todo->delete();

        return true;
    }

    // change mode 'dark or light'
    public function changeMode()
    {
        $usr = \Auth::user();
        if ($usr->mode == 'light') {
            $usr->mode      = 'dark';
            $usr->dark_mode = 1;
        } else {
            $usr->mode      = 'light';
            $usr->dark_mode = 0;
        }
        $usr->save();

        return redirect()->back();
    }

    public function upgradePlan($user_id)
    {
        $user = User::find($user_id);
        $plans = Plan::get();
        return view('user.plan', compact('user', 'plans'));
    }
    public function activePlan($user_id, $plan_id)
    {

        $user       = User::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan       = Plan::find($plan_id);
        if ($assignPlan['is_success'] == true && !empty($plan)) {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => isset(\Auth::user()->planPrice()['currency']) ? \Auth::user()->planPrice()['currency'] : '',
                    'txn_id' => '',
                    'payment_status' => 'success',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );

            return redirect()->back()->with('success', 'Plan successfully upgraded.');
        } else {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }

    }

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);

        return view('user.reset', compact('user'));

    }

    public function userPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('users.index')->with(
            'success',
            'User Password successfully updated.'
        );


    }


    //start for user login details
    public function userLog(Request $request)
    {
        $filteruser = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $filteruser->prepend('Select User', '');

        $query = DB::table('login_details')
            ->join('users', 'login_details.user_id', '=', 'users.id')
            ->select(DB::raw('login_details.*, users.id as user_id , users.name as user_name , users.email as user_email ,users.type as user_type'))
            ->where(['login_details.created_by' => \Auth::user()->id]);

        if (!empty($request->month)) {
            $query->whereMonth('date', date('m', strtotime($request->month)));
            $query->whereYear('date', date('Y', strtotime($request->month)));
        } else {
            $query->whereMonth('date', date('m'));
            $query->whereYear('date', date('Y'));
        }

        if (!empty($request->users)) {
            $query->where('user_id', '=', $request->users);
        }
        $userdetails = $query->get();
        $last_login_details = LoginDetail::where('created_by', \Auth::user()->creatorId())->get();

        return view('user.userlog', compact('userdetails', 'last_login_details', 'filteruser'));
    }

    public function userLogView($id)
    {
        $users = LoginDetail::find($id);

        return view('user.userlogview', compact('users'));
    }

    public function userLogDestroy($id)
    {
        $users = LoginDetail::where('user_id', $id)->delete();
        return redirect()->back()->with('success', 'User successfully deleted.');
    }

    //end for user login details


}
