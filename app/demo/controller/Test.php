<?php
namespace app\demo\controller;

//use app\Request;
use app\BaseController;

class Test extends BaseController
{
    //不知道为什么要设置这个，手册要我就放这吧
    //protected $request;
    //hello是关键词一样的东西
    public function index($name = '美丽的ThinkPHP6')
    {
        return 'hello,' . $name;
    }
    
    //依赖注入
    /*public function __construct(Request $request)
    {
        $this->request=$request;
    }*/
    //打印当前页面信息
    public function cc(/*Request $obj*/)
    {
        /*$a = $this->request->param('a');
        $b = $this->request->param('b');
        dump($a, $b);*/
        //dump($this->request->get());
        //dump($this->request->post());
        dump(request()->param());
        die;
        //获取指定字段的值，即获取本次指定的值
        //dd(request()->only(['id','name']));
        //获取id后转为int型
        $arr=[
            'id'=>1,
            'name'=>'冯志权',
            'age'=>'18',
            'title'=>'迷茫的张三吗?'
        ];
        return json(['result'=>$arr]);
        //echo "<hr/>";
        //var_dump($this->request->param("abc",18,"intval"));
        //echo "<hr/>";
        //dd($obj->param());
        //第三种方式
        //dd(input());
    }
    
    //测试
    public function test()
    {
        
    }
    
    
    
    
    
}
