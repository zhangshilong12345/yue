<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\View;
use think\Request;
use think\captcha\facade\Captcha;

class photo extends BaseController
{
    use Jump;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //返回登录页面
        return View::fetch("register");
    }
//验证码
//    public function verify()
//    {
//        return Captcha::create();
//    }

//    function verify() {
//        ob_clean();//丢弃输出缓冲区中的内容
//
//        $config = array(
//            'fontSize'    =>    20,    // 字体大小
//            'length'      =>    4,     // 验证码位数
//            'useCurve'    =>    false, // 开关验证码杂点
//            'useImgBg'    =>    true   //图片背景图
//        );
//
//        $Verify = new \Think\Verify($config);
//
//        $Verify->codeSet = '0123456789';//defghijklmnopqrstvuw
//
//        $Verify->entry();
//    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //这是注册的页面
        return View::fetch("registers");
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //这是登录的方法
        $resiter=[
            "username"=>$request->post("username"),
            "password"=>$request->post("password")
        ];
        if(Db::table('yong')->select($resiter)){
            $this->success("登录成功","photo/index");
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        //这是注册的方法
        $re=[
            "username"=>$request->post("username")
        ];
        $file=$request->file("img");
        if($file){
            $image=\think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
            $re["img"]="/storage/".$image;
        }
        if(Db::table('imgs')->insert($re)){
            $this->success("注册成imgs功","photo/create");
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function list()
    {
        //这是图片相册列表展开的返回页面
        $listFile=Db::table('imgs')->paginate(3);
        View::assign("list",$listFile);
        return View::fetch("list");
    }

    public function tupian(Request $request)
    {
        //设置一个图片上传的什么验证
        $file=$request->file("img");
        if($file){
            $image=\think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
            $re["img"]="/storage/".$image;
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function fens()
    {
        //这是图片分页返回的数据
        $listFiles=Db::table('imgs')->paginate(3);
        View::assign("fensen",$listFiles);
        return View::fetch("fensen");
    }
}
