<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticTextField
 *
 * @author 志鹏
 */
class StaticTextField extends FieldsAbstract {
    
    protected $inputTemplate = '%s';
    
    public function makeHTML($label, $fieldDefine) {
        return parent::makeFinalHTML($label, $fieldDefine["value"]);
//        parent::makeHTML($label, $fieldDefine);
    }
    
}
