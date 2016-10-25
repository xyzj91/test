<?php

/**
 * @filename Form.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-11-23  11:33:34
 * @Description
 * 
 */
 namespace app\form;
 use think\Model;
class Form extends Model{
    
    protected $hasForm = false;
    
    protected $formStruct;
    
    protected $requiredList = array();
    
    /**
     * 是否编辑表单
     * **/
    public $isEdit = false;
    
    public function __construct($model, $action="", $groupName = "") {
        
        if(is_array($model)) {
            $this->formStruct = $model;
            $this->hasForm = true;
            return;
        }
        $groupName = $groupName ? $groupName : MODULE_NAME;
        if($action) {
            $file = sprintf("%s/Conf/Forms/%s/%s%s.php", APP_PATH,$groupName, $model, $action);
        } else {
            $file = sprintf("%s/Conf/Forms/%s/%s.php", APP_PATH,$groupName, $model);
        }
		dump($file);
        if(!file_exists_case($file)) {
            $file = sprintf("%s/Conf/Forms/%s.php", APP_PATH, $model);
        }
//        echo $file;exit;
        if(file_exists_case($file)) {
            $key = md5($file);
            if(!key_exists($key, $this->requiredList)) {
                $this->requiredList[$key] = require $file;
            }
            $this->formStruct = $this->requiredList[$key];
            $this->hasForm = true;
        } else {
            // 尝试读取数据表
            
            
        }
        
        
    }
    
    public function makeForm($action = null, $data = "", $onlyField=false) {
        if(!$this->hasForm) {
            return false;
        }
//        print_r($data);exit;
        
        $fields = $this->formStruct["fields"];
        
        if(null === $action) {
            if($this->isEdit) {
                $fields["id"] = array(
                    "type" => "hidden",
                    "value"=> $_GET["id"]
                );
                $action = "__URL__/update";
            } else {
                $action = "__URL__/insert";
            }
        }
        
        
        unset($this->formStruct["fields"]);
        
        $actions = $this->formStruct["actions"];
        unset($this->formStruct["actions"]);
        
        unset($this->formStruct["title"]);
        $this->formStruct["class"] =  (false === strpos($this->formStruct["class"], "form-horizontal")) 
                                        ? "form-horizontal"
                                        : $this->formStruct["class"] ;
        $this->formStruct["action"] = $this->formStruct["action"] ? $this->formStruct["action"] : $action;
        $this->formStruct["method"] = $this->formStruct["method"] ? $this->formStruct["method"] : "POST";
        //<form> 属性
        foreach($this->formStruct as $k=>$v) {
            $formAttr[] = sprintf('%s="%s"', $k, $v);
        }
        
        import("@.Form.FieldsInterface");
        import("@.Form.FieldsAbstract");
        
        /**
         * 字段
         */
        foreach($fields as $k=>$v) {
            
            if(!$k or is_int($k)) {
                $k = $v;
                $v = array();
            }
            $v["name"] = $v["name"] ? strtolower($v["name"]) : $k;
            
            /*
             * 加入编辑表单默认数据
             * **/
            if($this->isEdit) {
                if($v["hoe"]) {
                    continue;
                }
            }
            $trimName = str_replace("[]", "", $v["name"]);
            if(isset($data[$trimName])) {
                $v["value"] = $data[$trimName];
            }
            
            $v["type"] = $v["type"] ? $v["type"] : "text";
            $label = isset($v["label"]) ? $v["label"] : $k;
            $v["id"] = isset($v["id"]) ? $v["id"] : "id_".$k;
            
            $type = ucfirst($v["type"]);
            $file = "@.Form.Fields.".$type."Field";
            import($file);
            
            $fieldClassName = $type."Field";
//            echo $fieldClassName;exit;
            if(!class_exists($fieldClassName)) {
                continue;
            }
            $fieldClass = new $fieldClassName();
            $fieldClass->data = $data[$trimName];
            $theFieldsHTML[] = $fieldClass->makeHTML($label, $v);
            
            if($fieldClass->endHTML) {
                $endHTML[] = $fieldClass->endHTML;
            }
        }
        if(!$actions){
           $actions["submit"] = $actions["submit"] ? $actions["submit"] : array(
               "type" => "submit",
               "class"=> "btn btn-primary"
           );
           $actions["go_back"] = $actions["go_back"] ? $actions["go_back"] : array(
               "type" => "button",
               "class"=> "btn",
               "onclick"=> "javascript:history.go(-1);"
           );
        } else {
            $actions = $this->formStruct["actions"];
        }
        
        /**
         * 按钮
         * **/
        import("@.Form.Fields.ButtonField");
        $btn = new ButtonField();
        foreach($actions as $k=>$v) {
            $theActionsHTML[] = $btn->makeHTML($k, $v);
        }
        $theActionsHTML = sprintf('<div class="form-actions">%s</div>', implode(" ", $theActionsHTML));
        
        if($onlyField) {
            return implode(" ", $theFieldsHTML);
        } else {
            $view = Think::instance("View");
            $view->assign("endHTML", implode("", $endHTML));
            return sprintf("<form %s>%s%s</form>", 
                implode(' ',$formAttr), 
                implode(' ',$theFieldsHTML), 
                $theActionsHTML);
        }
    }
    
}

?>
