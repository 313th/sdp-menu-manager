<?php

namespace sahifedp\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

/**
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $icon
 * @property integer $arrangement
 * @property string $created_at
 * @property string $updated_at
 * @property MenuItem[] $menuItems
 */
class MenuGroup extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'title', 'arrangement', 'icon', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'group_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'menu_groups_permissions','group_id','permission_id');
    }

    public function getMyItemsAttribute(){
        return MenuItem::where(['group_id'=>$this->id])
            ->whereHas('permissions',function ($query){
                return $query->whereIn('permission_id',Auth::user()->getAllPermissions()->pluck('id'));
            })
            //->whereIn('permission_id',Auth::user()->getAllPermissions()->pluck('id'))
            ->orderBy('arrangement')
            ->get();
    }
}
