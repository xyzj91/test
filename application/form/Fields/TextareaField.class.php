<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextareaField
 *
 * @author 志鹏
 */
class TextareaField extends FieldsAbstract {
    
    protected $inputTemplate = '<textarea %s>%s</textarea>';
    
    public function makeHTML($label, $fieldDefine) {
        $value = $fieldDefine["value"];
        unset($fieldDefine["value"]);
        $html = sprintf($this->inputTemplate, $this->makeAttr($label, $fieldDefine), $value);
        return $this->makeFinalHTML($label, $html);
    }
    
}
