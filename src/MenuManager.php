<?php


namespace sahifedp\MenuManager;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use sahifedp\MenuManager\Models\MenuGroup;
use sahifedp\MenuManager\Models\MenuItem;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuManager {
    //TODO: Define DELETE method for menu items and menu groups
    public static function newGroup($name,$title,$permissions,$arrangement=0,$icon="th"){
        $permission_ids = [];
        $superAdmin = Role::where(['name'=>'Super Admin'])->first();
        foreach(explode('|',$permissions) as $permission) {
            $permission_model = Permission::firstOrCreate(['name' => $permission]);
            $permission_ids[] = $permission_model->id;
        }
        if(empty($permission_ids)){
            return false;
        }
        $superAdmin->givePermissionTo($permission_ids);
        $model = MenuGroup::firstOrNew([
            'name' => $name,
        ]);
        $model->title = $title;
        $model->arrangement = $arrangement;
        $model->icon = $icon;
        $model->save();
        $model->permissions()->sync($permission_ids);
        return $model;
    }

    public static function newItem($group_id, $name, $title, $route, $permissions,$arrangement=0, $icon="circle-o"){
        $permission_ids = [];
        foreach(explode('|',$permissions) as $permission) {
            $permission_model = Permission::firstOrCreate(['name' => $permission]);
            $permission_ids[] = $permission_model->id;
        }
        if(empty($permission_ids)){
            return false;
        }

        $model = MenuItem::firstOrNew([
            'group_id' => $group_id,
            'name' => $name,
        ]);
        $model->title = $title;
        $model->arrangement = $arrangement;
        $model->icon = $icon;
        $model->route = $route;
        $model->save();
        $model->permissions()->sync($permission_ids);
        return $model;
    }

    public static function myMenu(){
        return MenuGroup::
            whereHas('permissions',function ($query){
                return $query->whereIn('permission_id',Auth::user()->getAllPermissions()->pluck('id'));
            })
            ->orderBy('arrangement')
            ->get();
    }
}
