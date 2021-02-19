<?php


namespace sahifedp\MenuManager;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use sahifedp\MenuManager\Models\MenuGroup;
use sahifedp\MenuManager\Models\MenuItem;
use Spatie\Permission\Models\Permission;

class MenuManager {
    public static function newGroup($name,$title,$permissions,$icon="th"){
        if(Permission::where(['name'=>$name])->count() > 0){
            return false;
        }
        $status = TRUE;
        foreach(explode('|',$permissions) as $permission) {
            $permission_model = Permission::firstOrCreate(['name' => $permission]);
            $model = new MenuGroup;
            $model->name = $name;
            $model->title = $title;
            $model->permission_id = $permission_model->id;
            $model->icon = $icon;
            $status = $status && $model->save();
        }
        return $status;
    }

    public static function newItem($group_id, $name, $title, $route, $permissions, $icon="circle-o"){
        if(Permission::where(['name'=>$name])->count() > 0){
            return false;
        }
        $status = TRUE;
        foreach(explode('|',$permissions) as $permission) {
            $permission_model = Permission::firstOrCreate(['name'=>$permission]);
            $model = new MenuItem;
            $model->group_id = $group_id;
            $model->name = $name;
            $model->title = $title;
            $model->route = $route;
            $model->permission_id = $permission_model->id;
            $model->icon = $icon;
            $status = $status && $model->save();
        }
        return $status;
    }

    public static function myMenu(){
        global $permissions;
        $permissions = Auth::user()->getAllPermissions()->pluck('id');
        return MenuGroup::with('menuItems')
            ->whereIn('permission_id',$permissions)
            ->whereHas('menu_items',function ($query){
                global $permissions;
                return $query->whereIn('permission_id',$permissions);
            });
    }
}
