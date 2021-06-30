<?php 
namespace CompleteSolar\MVC\Html;

class Link extends HtmlObject{
    
    public function __construct($href, $rel, $type = "text/css"){
        parent::__construct("link");
        $this->addAttribute("href", $href);
        $this->addAttribute("rel", $rel);
        $this->addAttribute("type", $type);
    }
}