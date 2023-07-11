<?php

namespace Osi\Airs\Http\Controllers;

use Illuminate\Http\Request;
use Osi\Airs\Http\Requests\Menu\CreateOrUpdateRequest;
use Osi\Airs\Models\Menu;
use Osi\Airs\Models\Role;
use Osi\Airs\Resources\Menu as MenuResource;

class MenuController extends Controller
{
    /**
     * @author airs<zk_admin@163.com>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->where('guard_name', $request->input('guard_name', 'admin'))
            ->orderBy('sequence', 'desc')
            ->get();

        return response()->json(['data' => make_tree($menus->toArray())]);
    }
    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateRequest $request)
    {
        Menu::create($request->all());

        return $this->created();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function my(Request $request)
    {
        $guardName = data_get($request->user()->currentAccessToken(), "name", "admin");

        $userPermissions = $request->user()->getAllPermissions()->pluck('name');
        $menus = $request->user()->roles->flatMap(function (Role $role) {
            return $role->menus()->orderBy('sequence', 'desc')->orderBy('id')->get();
        })
            ->where('guard_name', $guardName)
            ->where('is_display', true)
            ->filter(function ($item) use ($userPermissions) {
                return !$item->permission_name || $userPermissions->contains($item->permission_name);
            });
        return response()->json(['data' => make_tree($menus->toArray())]);
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        $menu = Menu::query()->findOrFail($id);

        $menu->update($request->toArray());

        return $this->noContent();
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @return MenuResource
     */
    public function show($id)
    {
        return new MenuResource(Menu::query()->findOrFail($id));
    }

    /**
     * @author airs<zk_admin@163.com>
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::query()->findOrFail($id);

        if (Menu::query()->where('parent_id', $menu->id)->count()) {
            return $this->unprocesableEtity([
                'parent_id' => 'Please delete the submenu first.',
            ]);
        }

        $menu->delete();

        return $this->noContent();
    }
}
