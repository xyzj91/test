<?php

/**
 * @filename SelectField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  16:13:43
 * @Description
 * 
 */
import("@.Form.Fields.RelationField");
class SelectField extends RelationField {
    
    private $selectTemplate = '<select %s>%s</select>';
    private $optionTemplate = '<option value="%s"%s>%s</option>';
    
    public function makeHTML($label, $fieldDefine) {
        
        if($fieldDefine["multiple"]) {
            $fieldDefine["name"] = $fieldDefine["name"]."[]";
        }
        
        $fieldDefine["data-source"] = parent::getDataSource($fieldDefine);
        foreach($fieldDefine["data-source"] as $k=>$v) {
            $selected = "";
            if($this->data == $k or (is_array($this->data) and in_array($k, $this->data))) {
                $selected = " selected";
            }
            $options[] = sprintf($this->optionTemplate, $k, $selected, $v);
        }
        $html = sprintf($this->selectTemplate, 
                    $this->makeAttr($label, $fieldDefine),
                    implode("",$options));
        return $this->makeFinalHTML($label, $html);;
    }
    
}

?>
