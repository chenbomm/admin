<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserBonus extends Model
{
    //用户红包表
    protected $table="jy_user_bonus";
    public $timestamps=true;
//红包的发送记录
    public function getSendRecord($where=[]){
        $records=self::select('jy_user_bonus.id','username','phone','bonus_name','start_time','end_time','jy_user_bonus.status')
            ->leftJoin('jy_bonus','jy_bonus.id','=','jy_user_bonus.bonus_id')
            ->leftJoin('jy_user','jy_user.id','=','jy_user_bonus.user_id')
            ->where($where)
            ->orderBy('jy_user_bonus.id','desc')
            ->paginate(5);
        return $records;
    }
}
