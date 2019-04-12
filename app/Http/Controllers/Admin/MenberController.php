<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenberController extends Controller
{
    //列表
    public function list()
    {
        $menber = new Menber();
        $assign['menbers'] = $this->getPageList($menber);
        return view('admin.menber.list', $assign);
    }
    //详情
    public function detail($id)
    {
        $menber = new Menber();
        $assign['info'] = $menber->getInfo($id);
        return view('admin.menber.detail', $assign);
    }
}
