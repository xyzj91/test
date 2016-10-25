<?php

/**
 * @filename RadioField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  16:13:58
 * @Description
 * 
 */
import("@.Form.Fields.RelationField");
class RadioField extends RelationField {
    
    private $radioTemplate = '<label><input %s />%s</label>';
    
    public function makeHTML($label, $fieldDefine) {
        $fieldDefine["data-source"] = parent::getDataSource($fieldDefine);
        $checked = explode(",", $fieldDefine["checked"]);
        foreach($fieldDefine["data-source"] as $k=>$v) {
            if(in_array($k, $checked)) {
                $fieldDefine["checked"] = "checked";
            } else {
                unset($fieldDefine["checked"]);
            }
            $fieldDefine["value"] = $k;
            $html[] = sprintf($this->radioTemplate, $this->makeAttr($label, $fieldDefine), $v);
        }
        
        return $this->makeFinalHTML($label, implode(" ", $html));
        
    }
    
}

?>
