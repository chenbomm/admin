<?php

namespace App\Http\Controllers\Admin;

use App\Model\Batch;
use App\Tools\ToolsAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchController extends Controller
{
    //批次的列表
    public function list(){
    $batch=new Batch();
    $assign['batch_list']=$this->getPageList($batch);
    return view('admin.batch.list',$assign);
    }
    //添加页面
    public function add(){
    return view('admin.batch.add');
    }
    //执行添加
    public function store(Request $request){
        $params=$request->all();
        $params=$this->delToken($params);
        $params['file_path']=ToolsAdmin::uploadFile($params['file_path'],false);
        $batch=new Batch();
        $res=$this->storeData($batch,$params);
        if (!$res){
            return redirect()->back()->with('msg','添加失败');
        }
        return redirect('/admin/batch/list');
    }
    //删除
    public function del($id){
        $batch=new Batch();
        $this->delData($batch,$id);
        return view('admin.batch.list');

    }
    //执行批次
    public function doBatch($id){

    }
}
