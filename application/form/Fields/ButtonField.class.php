<?php

/**
 * @filename ButtonField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  15:14:39
 * @Description
 * 
 */
class ButtonField extends FieldsAbstract {
    
    public function makeHTML($label, $fieldDefine) {
        $tpl = '<button type="%s" %s>%s</button>';
        
        $type = $fieldDefine["type"];
        unset($fieldDefine["type"]);
        
        $fieldDefine["class"] = $fieldDefine["class"] ? $fieldDefine["class"] : "btn";
        
        foreach($fieldDefine as $k=>$v) {
            $extra[] = sprintf('%s="%s"', $k, $v);
        }
        
        return sprintf($tpl, $type, implode(" ",$extra), L($label));
    }
    
}

?>
