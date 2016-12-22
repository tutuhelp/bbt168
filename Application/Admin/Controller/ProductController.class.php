<?php
namespace Admin\Controller;

/**
 * 后台商品控制器
 * @author Seven
 *
 */
class ProductController extends AdminController{
    
    /**
     * 商品列表
     * @author Seven
     */
    public function index(){
        
        $output = array();
        
        //标题栏
        $output['list_grids'] = array(
            array('title'=>'编号','field'=>array('id')),
            array('title'=>'商品名称','field'=>array('name')),
            array('title'=>'商品分类','field'=>array('cid')),
            array('title'=>'状态','field'=>array('status')),
            array('title'=>'操作','field'=>array('id'),'href'=>'[EDIT]&id=[id]|编辑,product/setstatus?status=-1&ids=[id]|删除'),
        );
        
        $list = $this->lists('products');
        
        $output['list'] = $list;
        $this->toDisplay($output);
    }
    
    /**
     * 添加商品
     * @author Seven
     */
    public function add(){
        
        if(IS_POST){
            //post递交数据
            $data = I("post.");
            //dump($data);die;
            $product = M('Products');
            
            if($product->create($data)){
                $res = $product->add();
                if($res){
                    $this->success("新增商品成功！",U("index"));
                }
            }
            $this->error("新增商品失败！");
            die;
        }
        
        $this->toDisplay($output);
        
    }
    
    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
        //获取左边菜单
        //$this->getMenu();
        
        if(IS_POST){
            //post递交数据
            $data = I("post.");
            //dump($data);die;
            $product = M('Products');
            
            if($product->create($data)){
                $res = $product->save();
                if($res){
                    $this->success("编辑商品成功！",U("index"));
                }
            }
            $this->error("编辑商品失败！");
            die;
        }
    
        $id     =   I('get.id',0);
        if(empty($id)){
            $this->error('参数不能为空！');
        }
        
        $data = M('Products')->where("id={$id}")->find();

        if(!$data){
            $this->error("商品不存在");
        }
    
        $output = array();
        $output['info'] = $data;
        $output['meta_title'] = "编辑商品";
    
        $this->toDisplay($output);
    }
    
}