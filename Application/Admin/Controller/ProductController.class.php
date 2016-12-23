<?php
namespace Admin\Controller;

/**
 * 后台商品控制器
 * @author Seven
 *
 */
class ProductController extends AdminController{
    
    /**
     * 分类树结构
     * @var array
     */
    private $categories;
    
    public function __construct(){
        
        parent::__construct();
        
        $map  = array('status' => array('gt', -1));
        $categories = M("product_category")->field($field)->where($map)->order('sort')->select();
        
        $this->categories = $categories;
    }
    
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
        
        $output = array(
            'meta_title' => "新增商品"
        );
        $output['tree'] = D("Tree","Logic")->toFormatTree($this->categories);
        
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
    
        $output = array(
            'meta_title' => "编辑商品"
        );
        $output['tree'] = D("Tree","Logic")->toFormatTree($this->categories);
        $output['info'] = $data;
    
        $this->toDisplay($output);
    }
    
    /**
     * 商品分类
     * @author Seven
     */
    public function category(){
        
//         $category = M('product_category');
        
//         $field = "*";
//         $map  = array('status' => array('gt', -1));
//         $list = $category->field($field)->where($map)->order('sort')->select();
        $tree = list_to_tree($this->categories, $pk = 'id', $pid = 'pid', $child = '_', $root = 0);
        //dump($tree);die;
        $output = array();
        $output['meta_title'] = "商品分类管理";
        $output['tree'] = $tree;
        
        $this->toDisplay($output);
    }
    
    /**
     * 添加分类
     * @author Seven
     */
    public function categoryAdd(){
        
        $category = M("product_category");
        
        if($category->create()){
            $res = $category->add();
            if($res){
                $this->success("添加成功！",U("category"));
            }
        }
        $this->error("添加失败！");
    }
    
    /**
     * 编辑商品分类
     * @author Seven
     */
    public function categoryEdit(){
        
        $id = I('id',0);
        
        if(empty($id)){
            $this->error("错误请求！");
        }
        
        $category = M('product_category');
        
        
        
        if(IS_POST){
            
            if($category->create()){
                $res = $category->save();
                
                if($res !== false){
                    $this->success("编辑成功！",U("category"));
                }
                
            }
            $this->error("编辑失败！");
            die;
        }
        
        $where = array(
            'pid' => 0,
            'status' => array("egt",0),
            'id' => array("neq",$id),
            
        );
        //获取所有顶级分类
        $parent = $category->where($where)->order('sort')->select();
        
        $info = $category->where(array('id'=>$id))->find();
        
        $output = array();
        
        $output['meta_title'] = "编辑商品分类";
        $output['tree'] = $parent;
        $output['info'] = $info;
        
        $this->toDisplay($output);
        
    }
    
    /**
     * 分类树形结构
     * @author Seven
     * @param array $tree
     */
    public function categoryTree($tree = null){       
        
        $output = array();
        $output['tree'] = $tree;
        $this->toDisplay($output,'tree');
        
    }
    
}