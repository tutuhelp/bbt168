<?php
namespace Home\Controller;

class ProductController extends HomeController{
    
    /**
     * 样品
     * @author Seven
     */
    public function sample(){
        
        $where = array(
            'status' => 1,
        );
        //商品列表
        $list = M("products")->where($where)->select();
        
        $output = array();
        $output['list'] = $list;
        
        $this->toDisplay($output,'list');
        
    }
    
}