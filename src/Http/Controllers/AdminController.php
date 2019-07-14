<?php

namespace GeekCms\Users\Http\Controllers;

use App\Models\User;
use Exception;
use Gcms;
use GeekCms\Users\Models\Users;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PackageSystem;
use function count;

class AdminController extends Controller
{
    /**
     * Method for show users list table.
     *
     * @return Factory|View
     */
    public function index()
    {
        $users = Users::orderBy('created_at', 'desc')->get();

        return view('users::index', [
            'users' => $users,
        ]);
    }

    /**
     * Route for delete more one users by id.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteAll(Request $request)
    {
        $get_users = $request->get('items', '');
        $get_users = explode(',', $get_users);

        if (count($get_users)) {
            $find_user = User::whereIn('id', $get_users);
            if ($find_user->count()) {
                foreach ($find_user->get() as $user) {
                    $user->syncPermissions();
                    $user->delete();
                }
            }
        }

        return redirect()->route('admin.users');
    }

    /**
     * Method for remove selected user.
     *
     * @param User $user
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function delete(User $user)
    {
        $user->syncPermissions();
        $user->delete();

        return redirect()->route('admin.users');
    }

    /**
     * Route for show view for edit user or create.
     *
     * @param User $user
     *
     * @return Factory|View
     */
    public function form(User $user)
    {
        $template = (empty($user->id)) ? 'users::create' : 'users::edit';
        $permissions = PackageSystem::getPermissionsList();

        return view($template, [
            'user' => $user,
            'permissions' => $permissions,
            'init_permissions' => $user->getPermissionNames()->toArray(),
        ]);
    }

    /**
     * Method for save users changes or create new.
     *
     * @param Users $user
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function save(Users $user, Request $request)
    {
        $password = false;
        $user_permissions = $request->post('user_permission', []);
        $password_new = $request->post('password', false);
        $password_confirmation = $request->post('password_confirmation', false);

        if (!empty($password_new) && $password_new && $password_confirmation && $password_new === $password_confirmation) {
            $password = $password_new;
        }

        // profile
        $data = $request->except(['password', 'password_confirmation']);
        if ($password) {
            $data['password'] = $data['password_confirmation'] = bcrypt($password);
        }

        $user_top = $user->fill($data);
        $user_top->validate($data);
        $user_permissions = array_keys($user_permissions);
        $user_permissions[] = Gcms::MAIN_ADMIN_PERMISSION;

        // pass
        if (!count($user_top->errors)) {
            $user_top->save();

            if (!$user_top || empty($user_top->id)) {
                throw new Exception('wtf is going on');
            }

            $user = User::findOrFail($user_top->id);
            $user->fill($data);
            $user->syncPermissions($user_permissions);

            return redirect()->route('admin.users');
        }

        return redirect()->back()->withInput($data)->withErrors($user_top->errors);
    }
}
