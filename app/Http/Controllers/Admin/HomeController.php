<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //后台首页
    public function home()
    {
        //今日日期
        $today=date("Y-m-d");
        //明天日期
        $tommorrow=date("Y-m-d",strtotime('+1 day'));
        //一周前
        $lastWeek=date("Y-m-d",strtotime('-5 day'));
        /********************会员统计信息*********************/
        //会员总数
        $assign['member_nums'] = \DB::table('jy_user')->count('id');
        //今日会员注册总量
        $assign['today_register_num']=\DB::table('jy_user')->where('created_at','>=',$today)->where('created_at','<',$tommorrow)->count('id');
        //近一周会员注册量
        $res=\DB::table('jy_user')->where('created_at','>=',$lastWeek)->where('created_at','<',$tommorrow)->count('id');
        $assign['last_week_register']=$res/$assign['member_nums']*100;
        /********************会员统计信息*********************/
    	return view('admin.home.home',$assign);
    }
}
