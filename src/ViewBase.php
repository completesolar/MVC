<?php
namespace CompleteSolar\MVC;

abstract class ViewBase {
    protected $controller;

    function __construct($controller){
        $this->controller = $controller;
    }

    /*
     * This method displays the entire content of the page
     */
    abstract public function display();
    
    /*
     * This method sets the Head Section of an HTML the page.
    */
    abstract protected function setHead();

    protected function startPage(){
        $html = "<!DOCTYPE HTML>";
        $html .= "<html itemscope itemtype=\"http://schema.org/blog\">";
        echo $html;
    }

    protected function endPage(){
        echo "</html>";
    }

    protected function startBody(){
        echo '<body>';
    }

    protected function endBody(){
        echo '</body>';
    }
}