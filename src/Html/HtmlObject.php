<?php
namespace CompleteSolar\MVC\Html;

class HtmlObject{
    protected $attributes;
    protected $tag;
    protected $nestedObjects;
    
    static $voidElements = array('area','base','br','col',
                                  'command','embed','hr','img',
                                  'input','keygen','link','meta',
                                  'param','source','track','wbr');
    
    public function __construct($tag){
        $this->tag = strtolower($tag);
        $this->attributes = array();
        $this->nestedObjects = array();
    }
    
    public function addAttribute($name, $value){
        $this->attributes[strtolower($name)] = $value;
    }
    
    public function addNestedObject($htmlObject){
        $this->nestedObjects[] = $htmlObject;
    }
    
    public function __toString(){
        $ret = "<$this->tag";
        foreach($this->attributes as $key=>$value){
            $ret .= " $key=\"$value\"";
        }
        if (in_array($this->tag, HtmlObject::$voidElements)){
            $ret .= "/>";
        } else {
            $ret .= ">";
            foreach($this->nestedObjects as $obj){
                $ret .= $obj;
            }
            $ret .= "</$this->tag>";
        }
        return $ret;
    }
}