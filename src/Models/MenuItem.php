<?php

namespace sahifedp\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

/**
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $title
 * @property string $route
 * @property integer $permission_id
 * @property string $icon
 * @property integer $arrangement
 * @property string $created_at
 * @property string $updated_at
 * @property MenuGroup $menuGroup
 */
class MenuItem extends Model
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
    protected $fillable = ['group_id', 'name', 'title', 'route', 'permission_id', 'icon', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permissionModel()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
