<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'path1',
        'path2',
        'path3',
        'path4',
        'path5',
        'type',
        'detail',
    ];

    /**
     * paths属性のアクセサ: 配列として取得
     */
    public function getPathsAttribute()
    {
        return [
            $this->path1,
            $this->path2,
            $this->path3,
            $this->path4,
            $this->path5,
        ];
    }

    /**
     * paths属性のミューテータ: 配列として設定
     */
    public function setPathsAttribute(array $paths)
    {
        $this->attributes['path1'] = $paths[0] ?? null;
        $this->attributes['path2'] = $paths[1] ?? null;
        $this->attributes['path3'] = $paths[2] ?? null;
        $this->attributes['path4'] = $paths[3] ?? null;
        $this->attributes['path5'] = $paths[4] ?? null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

}
