<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','mobile','email'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['mobile' => 'integer'];

    protected $appends = ['gender'];

    protected function getGenderAttribute()
    {
        return 1 ? '男' : '女';
    }

}