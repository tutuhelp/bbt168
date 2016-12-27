<?php
namespace Home\Controller;

class ProductController extends HomeController{
    
//     private $categories;
    
//     public function __construct(){
        
//         parent::__construct(); 
        
//     }
    
    /**
     * 商品列表
     * @author Seven
     */
    public function index($p = 1, $id = 0){
        
//         if($id=="all"){
//             $ids = 
//         }
        $cid = intval($id);
        
        if($cid != $id){
            $this->error("分类不存在！");
        }
        
        
        $format = $this->formatCategory();
        
        $where = array(
            'status' => 1,
        );
        
        if($cid > 0){
            
            $info = $format['key'][$cid];
            //dump($info);die;
            if(empty($info)){
                $this->error("分类不存在！");
            }
            
            $ids = array($cid);
            //dump($format['parent'][$cid]);die;
            if($info['pid'] == 0 && !empty($format['parent'][$cid])){
                //所有子分类ID
                $ids = array_merge($ids,$format['parent'][$cid]);
            }
            //查询所有分类下的商品
            $where['cid'] = array('in',$ids);
            $meta_title = $info['name'];
        }else{
            $meta_title = "所有商品";
        }

        $row = 12;
        //商品列表
        $list = M("products")->page($p, $row)->where($where)->order("id DESC")->select();
        $count = M("products")->where($where)->count();
        
        
        $output = array(
            'meta_title' => $meta_title,
        );
        $output['list'] = $list;
        $output['page'] = page($count, $row);
        $output['category'] = $format['key'];
        
        $this->toDisplay($output,'list');
        
    }
    
    /**
     * 格式化分类
     * @author Seven
     */
    private function formatCategory(){
        
        $format = array();
        
        $categories = M('product_category')->where("status=1")->order('sort')->select();
        
        //取出所有ID
        $format['ids'] = array_column($categories, 'id');
        
        foreach($categories as $v){
            //父类做索引，子分类做值
            if($v['pid'] > 0){
                $format['parent'][$v['pid']][] = $v['id'];
            }
            //分类的ID作为索引
            $format['key'][$v['id']] = $v; 
        }
        
        return $format;
        
    }
    
}