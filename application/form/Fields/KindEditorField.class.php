<?php

/**
 * @filename KindEditorField.class.php  富文本编辑器组件
 * @encoding UTF-8 
 * @author 李乐 <a href="mailto:@qq.com">@qq.com</a>
 * @link <a href="http://www.sep-v.com">http://www.sep-v.com</a>
 * @license http://www.sep-v.com/code-license
 * @datetime 2013-12-7  16:09:08
 * @Description 
 * 
 */

class KindEditorField extends FieldsAbstract {
 
    public function makeHTML($label, $fieldDefine) {
    	
		if($fieldDefine[simple]){
			$items = "items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link'],";
		}
		
		$html= '<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create(\'textarea[name="'.$label.'"]\', {
					allowFileManager : true,
					langType : "'.$fieldDefine[langType].'",
					uploadJson : "'.C('IMG_UPLOAD_CONFIG')['URL'].'?waterlogo='.$fieldDefine[waterlogo].'",
					'.$items.'
					
				});
			});
		</script>';
		$html.='<textarea name="'.$label.'" style="width:'.$fieldDefine["width"].'px;height:'.$fieldDefine[height].'px;visibility:hidden;"></textarea>';
        return $this->makeFinalHTML($label, $html);
    }
    
}

?>
