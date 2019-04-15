<?php

namespace App\Http\Controllers\Admin;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //评论列表
    public function list(){
        $comment= new Comment();
        $assign['comment'] = $comment->getCommentList();
        return view('admin.goods.comment.list',$assign);
    }
    //删除
    public function del($id){
        $comment=new Comment();
        $this->delData($comment,$id);
        return redirect('/admin/goods/comment/list');
    }

}
