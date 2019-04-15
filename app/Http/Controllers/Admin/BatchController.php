<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchController extends Controller
{
    //批次的列表
    public function list(){

    }
    //添加页面
    public function add(){

    }
    //执行添加
    public function store(Request $request){
        $params=$request->all();
    }
}
