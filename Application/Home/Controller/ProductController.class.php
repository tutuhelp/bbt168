<?php
namespace Home\Controller;

class ProductController extends HomeController{
    
    public function __construct(){
        
        parent::__construct();
        
//         $cid = I('get.cid',0);
        
//         if(empty($cid)){
//             $this->error("页面不存在！");
//         }
        
        $categories = M('product_category')->where("status=1")->order('sort')->select();
        
        //dump($categories);die;
        
    }
    
    /**
     * 样品
     * @author Seven
     */
    public function sample($p = 1){
        
        //查询样品的分类id
        
        //样品分类的子ID
        
        //查询所有样品分类下的商品
        
        
        $where = array(
            'status' => 1,
        );
        
        $row = 12;
        //商品列表
        $list = M("products")->page($p, $row)->where($where)->select();
        $count = M("products")->where($where)->count();
        
        
        $output = array(
            'meta_title' => "样品列表"
        );
        $output['list'] = $list;
        $output['page'] = page($count, $row);
        
        $this->toDisplay($output,'list');
        
    }
    
}