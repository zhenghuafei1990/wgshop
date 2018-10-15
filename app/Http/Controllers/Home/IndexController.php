<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Model\Admin\Cate;

class IndexController extends Controller
{
    public function index()
    {
    	$cates = Cate::getCatesubs();
    	return view('/home/index',[
    		'title'=>'万购购物商城',
    		'cates'=>$cates
    	]);
    }
}
