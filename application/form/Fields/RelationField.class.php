<?php

/**
 * @filename RelationSelectField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-24  10:13:52
 * @Description
 * 
 */

class RelationField extends FieldsAbstract {
    
    public function makeHTML($label, $fieldDefine) { }
    
    public function getDataSource($fieldDefine) {
        if(is_array($fieldDefine["data-source"])) {
            return $fieldDefine["data-source"];
        }
        $model = D($fieldDefine["model"]);
        $data = $model->where($fieldDefine["condition"])->order($fieldDefine["order"])->select();
        $name = $fieldDefine["labelField"] ? $fieldDefine["labelField"] : "name";
        $id = $fieldDefine["valueField"] ? $fieldDefine["valueField"] : "id";
        return $model->getIndexArray($data, $name, $id);
    }
    
}

?>
