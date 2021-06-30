<?php
namespace CompleteSolar\MVC\Html;

class InnerHtml extends HtmlObject{
    protected $inner;
    
    public function __construct($inner){
        $this->inner = $inner;
    }
    
    public function __toString(){
        return $this->inner;
    }
}