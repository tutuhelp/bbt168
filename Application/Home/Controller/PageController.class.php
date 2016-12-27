<?php
namespace Home\Controller;

class PageController extends HomeController{
    
    /**
     * 关于我们
     * @author Seven
     */
    public function about(){
        $output = array(
            'meta_title' => '公司简介',
        );
        $this->toDisplay($output);
    }
    /**
     * 梦想拍
     * @author Seven
     */
    public function dream(){
        $output = array(
            'meta_title' => '梦想拍',
        );
        $this->toDisplay($output);
    }
    
}