<?php
$this->menu=array(
	//array('label'=>'List AccTemplate','url'=>array('index')),
	array('label'=>Yii::t('app','Manage Account Template'),'url'=>array('admin')),
);

 $this->beginWidget('MiniForm',array(
    'heaer' => Yii::t('app',"Create Account Template"),
)); 
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); 

 $this->endWidget(); 
?>