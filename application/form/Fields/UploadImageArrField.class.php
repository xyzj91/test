<?php

/**
 * @filename UploadImageField.class.php  多图片上传组件 一个页面中最多出现一次
 * @encoding UTF-8 
 * @author 李乐 <a href="mailto:@qq.com">@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-7  16:09:08
 * @Description 
 * 
 */

class UploadImageArrField extends FieldsAbstract {
    
    public function makeHTML($label, $fieldDefine) {
		$html= '<script>
					KindEditor.ready(function(K) {
						var editor = K.editor({
							allowFileManager : true,
							uploadJson : "'.C('IMG_UPLOAD_CONFIG')['URL'].'",
						});
						K(\'#upload_btn_'.$label.'\').click(function() {
							editor.loadPlugin(\'multiimage\', function() {
								editor.plugin.multiImageDialog({
									clickFn : function(urlList) {
										var div = K(\'#J_'.$label.'\');
										var hidd = K(\'#Jhidden_'.$label.'\');
										div.html(\'\');
										K.each(urlList, function(i, data) {
											div.append(\'<img src="\' + data.url + \'">\');
											hidd.append(\'<input type="hidden" name="'.$label.'[]" value="\' + data.url + \'">\');
										});
										editor.hideDialog();
									}
								});
							});
						});
					});
				</script>';
		//$html.= '<input type="hidden" id="imgbox_'.$label.'" name="'.$label.'" value="">';		
		$html.= '<div id="upload_btn_'.$label.'" class="upload_btn" style="margin-bottom: 5px;">批量上传</div>';
		$html.='<div  id="Jhidden_'.$label.'" class="kin_img_all"></div>';
		$html.='<div id="J_'.$label.'" class="kin_img_alllist"></div>';
		return $this->makeFinalHTML($label, $html);
    }
    
}

?>
