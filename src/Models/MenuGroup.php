<?php

namespace sahifedp\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer permission_id
 * @property string $icon
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
    protected $fillable = ['name', 'title', 'permission_id', 'icon', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'group_id');
    }
}
