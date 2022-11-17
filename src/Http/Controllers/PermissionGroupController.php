<?php

namespace Zkuyuo\Airs\Http\Controllers;


use Illuminate\Http\Request;
use Zkuyuo\Airs\Http\Requests\PermissionGroup\CreateOrUpdateRequest;
use Zkuyuo\Airs\Models\PermissionGroup;
use Zkuyuo\Airs\Models\Permission;
use Zkuyuo\Airs\Resources\PermissionGroupCollection;
use Zkuyuo\Airs\Resources\PermissionGroup as PermissionGroupResource;

class PermissionGroupController extends Controller
{
    /**
     * @author airs<zk_admin@163.com>
     * @param Request $request
     * @return PermissionGroupCollection
     */
    public function index(Request $request)
    {
        $permissionGroups = tap(PermissionGroup::latest(), function ($query) {
            $query->where(request_intersect(['name']));
        })->paginate();

        return new PermissionGroupCollection($permissionGroups);
    }

    /**
     *  @author airs<zk_admin@163.com>
     * @param Request $request
     * @return PermissionGroupCollection
     */
    public function all(Request $request)
    {
        $permissionGroups = PermissionGroup::latest()->get();

        return new PermissionGroupCollection($permissionGroups);
    }

    /**
     * @param $guardName
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardNameForPermissions($guardName)
    {
        $permissionGroups = PermissionGroup::query()
            ->with(['permission' => function ($query) use ($guardName) {
                $query->where('guard_name', $guardName);
            }])
            ->get()->filter(function($item)  {
                return count($item->permission) > 0;
            });

        return response()->json([
            'data' => array_values($permissionGroups->toArray())
        ]);
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateRequest $request)
    {
        PermissionGroup::create(request_intersect(['name']));

        return $this->created();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @return PermissionGroupResource
     */
    public function show($id)
    {
        return new PermissionGroupResource(PermissionGroup::findOrFail($id));
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        PermissionGroup::findOrFail($id)->update(request_intersect([
            'name'
        ]));

        return $this->noContent();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);

        if (Permission::query()->where('pg_id', $permissionGroup->id)->count()) {
            return $this->unprocesableEtity([
                'pg_id' => 'Please move or delete the vesting permission.'
            ]);
        }

        $permissionGroup->delete();

        return $this->noContent();
    }
}