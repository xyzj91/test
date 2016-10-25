<?php

/**
 * @filename FieldsAbstract.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  14:53:18
 * @Description
 * 
 */
abstract class FieldsAbstract implements FieldsInterface {
    
    public $fieldTemplate = '<div class="control-group"><label class="control-label">%s</label><div class="controls">%s</div></div>';
    
    protected $inputTemplate = '<input %s />';
    
    protected $exclude = array("validate", "data-source", "model", "condition", "order");
    
    protected $hide = false;
    
    public $endHTML;
    
    /**
     * 生成HTML
     */
    public function makeHTML($label, $fieldDefine) {
        if($fieldDefine["add-on-before"]) {
            $this->inputTemplate = sprintf('<div class="input-append"><span class="add-on">%s</span>%s</div>', 
                    $fieldDefine["add-on-before"], 
                    $this->inputTemplate);
        }
        if($fieldDefine["add-on-after"]) {
            $this->inputTemplate = sprintf('<div class="input-append">%s<span class="add-on">%s</span></div>', 
                    $this->inputTemplate,
                    $fieldDefine["add-on-after"]);
        }
        unset($fieldDefine["add-on-before"]);
        unset($fieldDefine["add-on-after"]);
        $html = sprintf($this->inputTemplate, $this->makeAttr($label, $fieldDefine));
        return $this->makeFinalHTML($label, $html);
    }
    
    /**
     * 生成属性
     */
    protected function makeAttr($label, $fieldDefine, $required="", $exclude = "") {
        
        if(false !== $fieldDefine["required"] and false !== $required) {
            $fieldDefine["required"] = "required";
        }
        if(false === $fieldDefine["required"]) {
            unset($fieldDefine["required"]);
        }
        
        $exclude = $exclude ? $exclude : $this->exclude;
        
        foreach($exclude as $v) {
            unset($fieldDefine[$v]);
        }
        
        foreach($fieldDefine as $k=>$v) {
            $extra[] = sprintf('%s="%s"', $k, $v);
        }
        
        return implode(" ", $extra);
    }
    
    /**
     * 加入包含层
     * **/
    protected function makeFinalHTML($label, $html) {
        $label = is_array(L($label)) ? $label : L($label);
        if(!$this->hide) {
            return sprintf($this->fieldTemplate, $label, $html);
        } else {
            return sprintf(str_replace('control-group', 'control-group hide', $this->fieldTemplate), $label, $html);
        }
        
    }
    
}

?>
