<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menber;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //订单列表
    public function list(){
        $order=new Order();
        $assign['list']=$this->getPageList($order);
        return view('admin.order.list',$assign);
    }
    //订单详情页面
    public function detail($id){
        $order=new Order();
        $orderGoods=new OrderGoods();
        $region=new Region();
        $member=new Menber();
        //订单基本信息
        $order=$this->getDataInfo($order,$id);
        //收货人的地址信息
        $country=$this->getDataInfo($region,$order->country);//国家
        $province=$this->getDataInfo($region,$order->province);//省份
        $city=$this->getDataInfo($region,$order->city);//市
        $district=$this->getDataInfo($region,$order->district);//地区/县
        $assign=[
            'country'=>$country->region_name,
            'province'=>$province->region_name,
            'city'=>$city->region_name,
            'district'=> $district->region_name,
        ];
       $assign['order']=$order;
       //订单商品信息
        $assign['order_goods']=$this->getDataList($orderGoods);
        $assign['member']=$this->getDataInfo($member,$order->user_id);
        return view('admin.order.detail',$assign);
    }
}
