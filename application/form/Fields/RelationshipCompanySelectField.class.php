<?php

/**
 * @filename RelationshipCompanySelectField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-4  9:13:47
 * @Description
 * 
 */
import("@.Form.Fields.AutoCompleteField");
class RelationshipCompanySelectField extends AutoCompleteField {
    
    public function makeHTML($label, $fieldDefine) {
        $fieldHTML = parent::makeHTML($label, $fieldDefine);
        $extra = <<<EOF
        <a href="#selectCustomerModal" id="selectCustomerBtn" data-toggle="modal" class="btn btn-primary">%s</a>
        <a href="#addCustomerModel" data-toggle="modal" class="btn btn-success">%s</a>
EOF;
        $endAddModal = <<<EOF
        <div id="addCustomerModel" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>%s</h3>
            </div>
            <form action="%s" method="POST">
                <div class="modal-body">
                    <div class="form-horizontal">%s</div>
                </div>
                <div class="modal-footer"> 
                    <input type="hidden" name="goto" value="%s" />
                    <button type="submit" class="btn btn-primary">%s</button> 
                    <a data-dismiss="modal" class="btn dismissModal" href="#">%s</a> 
                </div>
            </form>
        </div>
EOF;
        $endSelectModal = <<<EOF
        <div id="selectCustomerModal" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>%s</h3>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">%s</div>
            </div>
            <div class="modal-footer"> 
                <a data-dismiss="modal" class="btn dismissModal" href="#">%s</a> 
            </div>
        </div>
EOF;
        $extra = sprintf($extra, L("select"), L("add_new"));
        $endAddModal = sprintf($endAddModal, 
            L("add_new_rel_company"),
            U("/CRM/RelationshipCompany/insert"),
            toForm('RelationshipCompanyQuick', "", true, array(), "CRM"),
            $fieldDefine["goto"],
            L("save"), L("cancle")
        );
        $view = Think::instance("View");
        $view->assign("RelCompanyLists", $relCompanyList);
        $endSelectModal = sprintf($endSelectModal, 
            L("select_rel_company"),
            '<div id="RelCompanySelectBox"></div>',
            L("cancle")
        );
        
        $fieldHTML.=$extra;
//        var_dump(toForm('RelationshipCompanyQuick', "", true, array(), "CRM"));exit;
        
        if($_GET['rel_company_id']) {
            $fieldHTML.= <<<EOF
            RelCompany.assign_linkman('{$GET["rel_company_id"]}');     
EOF;
        }
        
        $this->endHTML .= $endAddModal.$endSelectModal;
        return $this->makeFinalHTML($label, $fieldHTML);
    }
    
}

?>
