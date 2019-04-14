<?php

namespace App\Http\Controllers\Admin;

use App\Model\Bonus;
use App\Model\Menber;
use App\Model\Region;
use App\Model\UserBonus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BonusController extends Controller
{
    //红包列表
    public function list(){
        $bonus=new Bonus();
        $assign['bonus_list']=$this->getPageList($bonus);
        return view('admin.bonus.list',$assign);
    }
    //红包添加
    public function addBonus(){
        return view('admin.bonus.add');
    }
    //执行红包得添加
    public function doAddBonus(Request $request){
        $params=$request->all();
        $params=$this->delToken($params);
        $bonus=new Bonus();
        $res=$this->storeData($bonus,$params);
        if (!$res){
            return redirect()->back()->with('msg','添加红包失败');
        }
        return redirect('/admin/bonus/list');
    }
    //发送红包
    public function senBonus($bonusId){
        $bonus=new Bonus();
        $assign['bonus_info']=$this->getDataInfo($bonus,$bonusId);
        return view('admin.bonus.send',$assign);
    }
    //执行发送红包
    public function doSenBonus(Request $request){
        $params=$request->all();
        $params=$this->delToken($params);
        //查询用户的信息
        $user=new Menber();
        $userInfo=$this->getDataInfo($user,$params['phone'],'phone');
        if (empty($userInfo)){
            return redirect()->back()->with('msg','用户不存在，红包发送失败');
        }
        //用户红包的数据
        $userBonusData=[
          'user_id'=>$userInfo->id,
          'bonus_id'=>$params['bonus_id'],
          'start_time'=>date('Y-m-d H:i:s'),
          'end_time'=>date('Y-m-d H:i:s',strtotime("+".$params['expires']."days")),
        ];
        $userBonus=new UserBonus();
        $res=$this->storeData($userBonus,$userBonusData);
        if (!$res){
            return redirect()->back()->with('msg','红包发送失败');
        }
        return redirect('/admin/bonus/list');
    }
}