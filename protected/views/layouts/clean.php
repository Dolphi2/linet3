<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="UTF-8">
        <?php
        Yii::app()->bootstrap->register();
        Yii::app()->tinymce->register();

        $cs = Yii::app()->getClientScript();
        $path = Yii::app()->createAbsoluteUrl('/assets/css/');

        $cs->registerCssFile($path . '/main.css');
        $cs->registerCssFile($path . '/linet.css');
        if (Yii::app()->language == 'he_il') {
            $cs->registerCssFile($path . '/linet-rtl.css');
        }
        ?>


        <link rel="shortcut icon" href="<?php echo Yii::app()->createAbsoluteUrl('/assets/img/favicon.ico'); ?>">
        <link rel="icon" type="image/ico" href="<?php echo Yii::app()->createAbsoluteUrl('/assets/img/favicon.ico'); ?>">        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>


    </head>

    <body class="login">
        <div id="modal" class="modal hide fade in" style="display: none; ">
            <div id="modal-header" class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Modal Heading</h3>
            </div>
            <div id="modal-body" class="modal-body">

            </div>
            <div id="modal-footer" class="modal-footer">
                <a href="#" class="btn btn-success">Action</a>
                <a href="#" class="btn" data-dismiss="modal">Close</a>
            </div>
        </div>



        <?php $this->widget('bootstrap.widgets.TbAlert'); ?>           




        <?php echo $content; ?>



        <div id="footer">
            מונע על ידי מחשוב מהיר<br>
            נכתב על ידי אדם בן חור<br>
            <a href="http://www.speedcomp.co.il/">www.speedcomp.co.il</a>
        </div>
    </body>
</html>
