<?php

/**
 * @filename EditorField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-27  17:32:19
 * @Description
 * 
 */
import("@.Form.Fields.TextareaField");
class EditorField extends TextareaField {
    
    public function makeHTML($label, $fieldDefine) {
        $fieldDefine["required"] = false;
        $fieldDefine["class"].= " textarea_editor span12";
        $fieldDefine["rows"] = $fieldDefine["rows"] ? $fieldDefine["rows"] : 12;
        $this->endHTML = <<<EOF
        <script src="__PUBLIC__/Js/jquery.ajaxFileUpload.js"></script> 
        <script src="__PUBLIC__/base/js/wysihtml5-0.3.0.js"></script> 
        <script src="__PUBLIC__/base/js/bootstrap-wysihtml5.js"></script> 
        <script>
            $('.textarea_editor').wysihtml5();
        </script>
EOF;
        return parent::makeHTML($label, $fieldDefine);
    }
    
}

?>
