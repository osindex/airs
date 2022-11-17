<?php

namespace Zkuyuo\Airs\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Zkuyuo\Airs\AdminUserFactory;
use Zkuyuo\Airs\Http\Requests\AdminUser\CreateOrUpdateRequest;
use Zkuyuo\Airs\Resources\AdminUser as AdminUserResource;
use Zkuyuo\Airs\Resources\AdminUserCollection;
use Zkuyuo\Airs\Resources\RoleCollection;

class AdminUserController extends Controller
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = AdminUserFactory::adminUser();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param Request $request
     * @return AdminUserCollection
     */
    public function index(Request $request)
    {
        $per_page = config('airs.page',  [
            'per_page' => 'per_page',
            'page'=> 'page',
        ],);
        return new AdminUserCollection($this->adminUserModel->where(request_intersect(['name', 'username']))->paginate($request->{$per_page['per_page']} ?? 15));
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @return AdminUserResource
     */
    public function show($id)
    {
        return new AdminUserResource($this->adminUserModel->findOrFail($id));
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @return Response
     */
    public function store(CreateOrUpdateRequest $request)
    {
        $data = request_intersect([
            'name', 'username', 'password',
        ]);
        $data['status'] = $request->status ? true : false;
        $data['password'] = bcrypt($data['password']);

        $this->adminUserModel->create($data);

        return $this->created();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return Response
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        $adminUser = $this->adminUserModel->findOrFail($id);

        $data = request_intersect([
            'name', 'status',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $adminUser->fill($data);
        $adminUser->save();

        return $this->noContent();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $adminUser = $this->adminUserModel->findOrFail($id);

        $adminUser->delete();

        return $this->noContent();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @param $provider
     * @return RoleCollection
     */
    public function roles($id, $provider)
    {
        $user = $this->getGuardModel($provider)->findOrFail($id);

        return new RoleCollection($user->roles);
    }

    /**
     * @param $id
     * @param $guard
     * @param Request $request
     * @return Response
     *@author airs<zk_admin@163.com>
     */
    public function assignRoles($id, $guard, Request $request)
    {
        $user = $this->getGuardModel($guard)->findOrFail($id);

        $user->syncRoles($request->input('roles', []));

        return $this->noContent();
    }

    /**
     * @param $guard
     * @return Illuminate\Foundation\Auth\User
     */
    private function getGuardModel($guard)
    {
        return app(config('airs.guards.' . $guard . '.model'));
    }

    /**
     * @author osi<osindex@gmail.com>
     * @param $id
     * @return AdminUserResource
     */
    public function me(Request $request)
    {
        return new AdminUserResource($request->user());
    }
}
