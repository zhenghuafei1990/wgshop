<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
     /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'goods';
    //主键
    protected $primarykey = 'id';
    //数据填充(不可被批量赋值的属性)
    protected $guarded = [];
    //该模型是否被自动维护时间戳
    public $timestamps = false;
    
    //关联商品图片表
    public function gimgs()
    {
        return $this->hasMany('App\Model\Admin\Goodsimg','gid');
    }
}
