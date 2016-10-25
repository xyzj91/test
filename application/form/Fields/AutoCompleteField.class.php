<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AutoCompleteField extends FieldsAbstract {
    
    
    public function makeHTML($label, $fieldDefine) {
        $fieldDefine["class"] = explode(" ", $fieldDefine["class"]);
        $fieldDefine["class"][] = $fieldDefine["type"];
        $fieldDefine["class"][] = "autocomplete";
        $fieldDefine["class"] = implode(" ", $fieldDefine["class"]);
        $fieldDefine["type"] = "text";
        
        $template = <<<EOF
                <input type="text" %s />
EOF;
        $html = sprintf($template, $this->makeAttr($label, $fieldDefine));
        
        return $html;
    }
    
}