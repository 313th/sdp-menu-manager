<?php


namespace sahifedp\MenuManager;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use sahifedp\MenuManager\Models\MenuGroup;
use sahifedp\MenuManager\Models\MenuItem;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuManager {
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
        $model = MenuGroup::firstOrCreate([
            'name' => $name,
            'title' => $title,
            'arrangement' => $arrangement,
            'icon' => $icon,
        ]);
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

        $model = MenuItem::firstOrCreate([
            'group_id' => $group_id,
            'name' => $name,
            'title' => $title,
            'route' => $route,
            'arrangement' => $arrangement,
            'icon' => $icon,
        ]);
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
