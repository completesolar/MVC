<?php 
namespace CompleteSolar\MVC\Html;

class Style extends HtmlObject{
    public function __construct(){
        parent::__construct("style");
    }
    
    public function addStyles($css){
       $this->addNestedObject(new InnerHtml($css));
    }
}