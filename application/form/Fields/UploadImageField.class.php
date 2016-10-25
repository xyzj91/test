<?php

/**
 * @filename UploadImageField.class.php  单图片上传组件
 * @encoding UTF-8 
 * @author 李乐 <a href="mailto:@qq.com">@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-7  16:09:08
 * @Description 
 * 
 */

class UploadImageField extends FieldsAbstract {
 
    public function makeHTML($label, $fieldDefine) {
		$html= '<script>
					KindEditor.ready(function(K) {
						var editor = K.editor({
							allowFileManager : true,
							uploadJson : "'.C('IMG_UPLOAD_CONFIG')['URL'].'",
						});
						K(\'#upload_btn_'.$label.'\').click(function() {
							editor.loadPlugin(\'image\', function() {
								editor.plugin.imageDialog({
									imageUrl : K(\'#imgbox_'.$label.'\').val(),
									clickFn : function(url, title, width, height, border, align) {
										K(\'#imgbox_'.$label.'\').val(url);
										K(\'#uu_'.$label.'\').append(\'<img src="\' + url + \'">\');
										editor.hideDialog();
									}
								});
							});
						});
					});
				</script>';
		$html.= '<input type="hidden" id="imgbox_'.$label.'" name="'.$label.'" value="">';		
		$html.= '<div id="upload_btn_'.$label.'" class="upload_btn" style="margin-bottom: 5px;">选择图片</div>';
		$html.='<div id="uu_'.$label.'" class="kin_img_alllist"></div>';
		return $this->makeFinalHTML($label, $html);
    }
    
}

?>
