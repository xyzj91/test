<?php

/**
 * @filename HiddenField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  16:48:43
 * @Description
 * 
 */
class HiddenField extends FieldsAbstract {
    
    public function makeHTML($label, $fieldDefine) {
        $this->hide = true;
        return sprintf($this->inputTemplate, $this->makeAttr($label, $fieldDefine));
    }
    
}

?>
