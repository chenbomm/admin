<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\BonusBatchJob;
use App\Model\Batch;
use App\Model\Bonus;
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
    public function doBatch($id)
    {
        //获取批次的信息
        $batch = new Batch();
        $batchInfo = $this->getDataInfo($batch, $id)->toArray();

        //获取上传文件的内容
        $fileContent = file_get_contents(substr($batchInfo['file_path'], 1));
        $arr =explode("\r\n", $fileContent);
        //发送红包的批次
        if($batchInfo['type'] == 1){
            //把读出来文件内容进行数组的拆分
            $arr = array_chunk($arr, 2);
            //红包的id
            $bonusId = $batchInfo['id'];
            $bonus = new Bonus();

            $bonusInfo = $this->getDataInfo($bonus,$bonusId);
//            dd($bonusInfo);
            //循环如队列
            foreach ($arr as $key => $value) {
                $data = [
                    'user_id' =>$value,
                    'bonus_id' => $bonusId,
                    'expires'  => $bonusInfo->expires
                ];
                //实例化队列任务类
                $job = new BonusBatchJob($data);
                //执行任务分发
                dispatch($job);
            }
        }
        //修改批次状态为已处理
        $batch = Batch::find($id);
        $this->storeData($batch, ['status'=>3]);

        return redirect('/admin/batch/list');
    }
}
