<?php

/**
 * @filename CheckboxField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  16:14:14
 * @Description
 * 
 */
import("@.Form.Fields.RelationField");
class CheckboxField extends RelationField {
    
    private $checkboxTemplate = '<label><input %s />%s</label>';
    
    public function makeHTML($label, $fieldDefine) {
        $fieldDefine["data-source"] = parent::getDataSource($fieldDefine);
//        print_r($fieldDefine);exit;
        $checked = explode(",", $fieldDefine["checked"]);
        foreach($fieldDefine["data-source"] as $k=>$v) {
//            
            if($this->data == $k 
                    or (is_array($this->data) and in_array($k, $this->data))
                    or (in_array($k, explode(",", $this->data)))
                    ) {
                $fieldDefine["checked"] = "checked";
            }
            else {
                unset($fieldDefine["checked"]);
            }
//            if(in_array($k, $checked)) {
//                $fieldDefine["checked"] = "checked";
//            } else {
//                unset($fieldDefine["checked"]);
//            }
            $fieldDefine["value"] = $k;
            $html[] = sprintf($this->checkboxTemplate, $this->makeAttr($label, $fieldDefine, false), $v);
        }
        
        return $this->makeFinalHTML($label, implode(" ", $html));
        
    }
    
}

?>
