<?php

namespace App\Http\Controllers\Admin;

use App\Model\Region;
use App\Tools\ToolsAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    //地区列表
    public function list($fid=0){
        $region=new Region();
        $assign['region_list']=$this->getDataList($region,['f_id'=>$fid]);
        return view('admin.region.list',$assign);
    }
    //地区添加
    public function add(){
        $region=new Region();
        $regions=$this->getDataList($region);
        $assign['region_list']=ToolsAdmin::buildTreeString($regions,0,0,'f_id');
        return view('admin.region.add',$assign);
    }
    //执行添加
    public function store(Request $request){
        $params=$request->all();
        $params=$this->delToken($params);
        //当前要添加地区得详细信息
        $region=new Region();
        $info=$this->getDataInfo($region,$params['f_id']);
        $params['level']=$info->level+1;
        $res=$this->storeData($region,$params);
        if (!$res){
            return redirect()->back()->with('msg','添加失败');
        }
        return redirect('/admin/region/list/'.$params['f_id']);

    }
    //删除地区
    public function del($id){
        $region=new Region();
        $info=$this->getDataInfo($region,$id);
        $this->delData($region,$id);
        return redirect('/admin/region/list/'.$info->f_id);
    }
}
