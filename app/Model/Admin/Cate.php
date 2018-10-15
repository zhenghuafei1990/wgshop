<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'type';
    //主键
    protected $primarykey = 'tid';
    //数据填充(不可被批量赋值的属性)
    protected $guarded = [];
    //该模型是否被自动维护时间戳
    public $timestamps = false;

    static public function getCateSubs($cates=[],$pid=0)
    {
    	if(empty($cates)){
    		$cates = self::all();
    	}
    	$arr=[]; 
    	foreach($cates as $k=>$v){
    		if($v->pid == $pid){
    			$v->sub = self::getCateSubs($cates,$v->tid);
    			$arr[]=$v;
    		}
    	}
    	return $arr;
    }
}
