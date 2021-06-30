<?php 
namespace CompleteSolar\MVC\Html;

class Script extends HtmlObject{
    public function __construct($type = "text/javascript"){
        parent::__construct("script");
        $this->addAttribute("type", $type);
    }
    
    public function setSrc($src){
        $this->addAttribute("src", $src);
    }
    
    public function setCharset($charset){
        $this->addAttribute("charset", $charset);
    }
    
    public function setDefer($defer){
        $this->addAttribute("defer",$defer);
    }
    
    public function addScript($script){
       $this->addNestedObject(new InnerHtml($script));
    }
}