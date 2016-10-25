<?php

/**
 * @filename RegionSelectField.class.php 
 * @encoding UTF-8 
 * @author nemo.xiaolan <a href="mailto:335454250@qq.com">335454250@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-7  16:09:08
 * @Description
 * 
 */
class RegionSelectField extends FieldsAbstract {
    
    private $provinceTpl = '<select id="province" cityid="%d" townid="%d" onchange="loadRegion(\'province\', 2, \'city\', \'%s\')">%s</select>';
    
    public function makeHTML($label, $fieldDefine) {
        $firstRegion = D("Region");
        $province = $firstRegion->where("pid=1")->order("listorder DESC, id ASC")->select();
        $provinceHTML[] = sprintf('<option>%s</option>', L("province_or_municipalities"));
        if($this->data) {
            $regs = getRegionPath($this->data);
        }
//        print_r($regs);exit;
        foreach($province as $p) {
            if($p["id"] == $regs["province"]["id"]) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $provinceHTML[] = sprintf('<option value="%d" %s>%s</option>', $p['id'], $selected, $p['name']);
        }
        
        $cityid = $this->data ? $regs["city"]["id"] : 0;
        $townid = $this->data ? $regs["town"]["id"] : 0;
        
        $html = sprintf($this->provinceTpl, $cityid, $townid, U("/HOME/Region/ajax_getRegion"), implode("", $provinceHTML));
        $extra = <<<EOF
                <select id="city" onchange="loadRegion('city',3,'town','%s');">
                    <option>%s</option>
                </select>
                <select name="%s" id="town">
                    <option>%s</option>
                </select>
EOF;
        $html.= sprintf($extra, U("/HOME/Region/ajax_getRegion"), L("city"), $fieldDefine["name"], L("town"));
        return $this->makeFinalHTML($label, $html);
    }
    
}

?>
