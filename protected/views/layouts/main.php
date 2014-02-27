<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
                
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

       
</head>

<body>
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
<div class="wrapper" id="page">
    
<nav class="navbar navbar-inverse navbar-static-top">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
            </button>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/settings/dashboard');?>" class="navbar-brand">
                Linet 3.0
              <!--<img src="assets/img/logo.png" alt="">-->
            </a> 
            <div class="topnav">
            <div class="btn-toolbar">
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                  <i class="glyphicon glyphicon-fullscreen"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Show / Hide Sidebar" data-toggle="tooltip" class="btn btn-success btn-sm" id="changeSidebarPos">
                  <i class="fa fa-expand"></i>
                </a> 
              </div>
              
              <div class="btn-group">
                
                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                  <i class="fa fa-question"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/Logout');?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a> 
              </div>
            </div>
          </div><!-- /.topnav -->  
              
              
          </header>
          
          <div class="navbar-collapse navbar-ex1-collapse collapse" style="height: 1px;">

           
         
        
         
	<?php 
	Yii::app()->bootstrap->register();

?>
		<?php 
		if(Yii::app()->user->isGuest){
			$menu=array(array('label'=>Yii::t('app','Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest));
		}else{
			$menu=array(
                            
		//Yii::t('app', 'message to be translated')
         array('label'=>Yii::t('app','Settings'),  'icon'=>'glyphicon glyphicon-cog','items'=>array(//'url'=>array('site/index'),
             //array('label'=>Yii::t('app','Logout'), 'url'=>array('/site/Logout')),
            array('label'=>Yii::t('app','Bussines details'), 'url'=>array('settings/admin')),
            //'---',
            //array('label'=>Yii::t('app','Accounts')),
            
             
           // '---',
            array('label'=>Yii::t('app','Manual Journal Voucher'), 'url'=>array('transaction/create')),
            array('label'=>Yii::t('app','Business docs'), 'url'=>array('doctype/admin')),
            array('label'=>Yii::t('app','Costum Fields'), 'url'=>array('eavFields/admin')),
            array('label'=>Yii::t('app','Currency rates'), 'url'=>array('currates/admin')),
            array('label'=>Yii::t('app','Openning balances'), 'url'=>array('transaction/openbalance')),
            array('label'=>Yii::t('app','Contact Item'), 'url'=>array('rm/admin')),
             array('label'=>Yii::t('app','Tax Catagory For Items'), 'url'=>array('ItemVatCat/admin')),
           //  '---',
            array('label'=>Yii::t('app','Manage Users'), 'url'=>array('users/admin')),
            array('label'=>Yii::t('app','Manage Groups'), 'url'=>array('rights/authItem/roles')),
        )),
                array('label'=>Yii::t('app','Accounts'), 'icon'=>'glyphicon glyphicon-folder-open','items'=>array(            
                array('label'=>Yii::t('app','Accounts'), 'url'=>array('accounts/index')),
                 
                array('label'=>Yii::t('app','Account Template'), 'url'=>array('accTemplate/admin')),
                array('label'=>Yii::t('app','Account Types'), 'url'=>array('acctype/admin')),           
                            
                            
                )),                                
        array('label'=>Yii::t('app','Stock'), 'icon'=>'glyphicon glyphicon-tag','items'=>array(
        	array('label'=>Yii::t('app','Items'), 'url'=>array('item/admin'),'visible'=>Yii::app()->user->checkAccess( 'item/admin', array() )),
        	array('label'=>Yii::t('app','Werehouses'), 'url'=>array('accounts/index','type'=>'8'),'visible'=>Yii::app()->user->checkAccess( 'accounts', array() )),
        	array('label'=>Yii::t('app','Categories'), 'url'=>array('itemcategory/admin'),'visible'=>Yii::app()->user->checkAccess( 'item/admin', array() )),
        	array('label'=>Yii::t('app','Units'), 'url'=>array('itemunit/admin'),'visible'=>Yii::app()->user->checkAccess( 'itemunit/admin', array() )),
        	array('label'=>Yii::t('app','Item Template'), 'url'=>array('itemTemplate/admin')),
        )),
		array('label'=>Yii::t('app','Income'), 'icon'=>'glyphicon glyphicon-thumbs-up','items'=>array(
			//array('label'=>Yii::t('app','Manage Customers'), 'url'=>array('accounts/contact','type'=>'0')),
			array('label'=>Yii::t('app','Proforma'), 'url'=>array('docs/create','type'=>'1')),
			array('label'=>Yii::t('app','Delivery doc.'), 'url'=>array('docs/create','type'=>'2')),
			array('label'=>Yii::t('app','Invoice'), 'url'=>array('docs/create','type'=>'3')),
			array('label'=>Yii::t('app','Credit inv.'), 'url'=>array('docs/create','type'=>'4')),
			array('label'=>Yii::t('app','Return doc.'), 'url'=>array('docs/create','type'=>'5')),
			array('label'=>Yii::t('app','Quote'), 'url'=>array('docs/create','type'=>'6')),
			array('label'=>Yii::t('app','Sales Order'), 'url'=>array('docs/create','type'=>'7')),
			array('label'=>Yii::t('app','Invoice receipt'), 'url'=>array('docs/create','type'=>'9')),
			
			array('label'=>Yii::t('app','Print docs.'), 'url'=>array('docs/admin')),
		)),
              
		array('label'=>Yii::t('app','Outcome'), 'icon'=>'glyphicon glyphicon-shopping-cart','items'=>array(
			array('label'=>Yii::t('app','Manage Suppliers'), 'url'=>array('accounts/index','type'=>'1')),
			array('label'=>Yii::t('app','Parchace Order'), 'url'=>array('docs/create','type'=>'10')),
			array('label'=>Yii::t('app','insert Buisness outcome'), 'url'=>array('docs/create','type'=>'13')),
			array('label'=>Yii::t('app','insert Asstes outcome'), 'url'=>array('docs/create','type'=>'14')),
		)),
		array('label'=>Yii::t('app','Register'), 'icon'=>'glyphicon glyphicon-usd','items'=>array(
			array('label'=>Yii::t('app','Receipt'), 'url'=>array('docs/create','type'=>'8')),
			array('label'=>Yii::t('app','Bank deposits'), 'url'=>array('deposit/admin')),
			array('label'=>Yii::t('app','Payment'), 'url'=>array('outcome/create')),
			array('label'=>Yii::t('app','VAT payment'), 'url'=>array('outcome/create','type'=>'1')),
			array('label'=>Yii::t('app','Nat. Ins. payment'), 'url'=>array('outcome/create','type'=>'2')),
		)),
		array('label'=>Yii::t('app','Reconciliations'), 'icon'=>'glyphicon glyphicon-eye-open','items'=>array(
			array('label'=>Yii::t('app','Bank docs entry'), 'url'=>array('bankbook/admin')),
			array('label'=>Yii::t('app','Bank recon.'), 'url'=>array('bankbook/extmatch')),
			array('label'=>Yii::t('app','Show bank recon.'), 'url'=>array('match/extindex')),
			array('label'=>Yii::t('app','Accts. recon.'), 'url'=>array('match/admin')),
			array('label'=>Yii::t('app','Show recon.'), 'url'=>array('match/index')),
		)),
		array('label'=>Yii::t('app','Reports'),'icon'=>'glyphicon glyphicon-stats','items'=>array(
			array('label'=>Yii::t('app','Display transactions'), 'url'=>array('reports/journal')),
			array('label'=>Yii::t('app','Customers owes'), 'url'=>array('reports/owe')),
			array('label'=>Yii::t('app','Profit & loss'), 'url'=>array('reports/profloss')),
			array('label'=>Yii::t('app','Monthly Prof. & loss'), 'url'=>array('reports/mprofloss')),
			array('label'=>Yii::t('app','VAT calculation'), 'url'=>array('reports/vat')),
			array('label'=>Yii::t('app','Balance'), 'url'=>array('reports/balance')),
			array('label'=>Yii::t('app','Income tax advances'), 'url'=>array('reports/taxrep')),
                        array('label'=>Yii::t('app','Income outcome'), 'url'=>array('reports/inout')),
		)),
		array('label'=>Yii::t('app','Import Export'), 'icon'=>'glyphicon glyphicon-transfer','items'=>array(
			array('label'=>Yii::t('app','Open docs'), 'url'=>array('data/openfrmt')),
			array('label'=>Yii::t('app','Open docs Import'), 'url'=>array('data/openfrmtimport')),
			array('label'=>Yii::t('app','General backup'), 'url'=>array('data/backup')),
			array('label'=>Yii::t('app','Backup restore'), 'url'=>array('data/restore')),
			array('label'=>Yii::t('app','PCN874'), 'url'=>array('data/pcn874')),
		)),
		array('label'=>Yii::t('app','Support'), 'icon'=>'glyphicon glyphicon-info-sign','items'=>array(
			array('label'=>Yii::t('app','Update'), 'url'=>array('module/update/')),
			array('label'=>Yii::t('app','Paid Support'), 'url'=>array('support')),
			array('label'=>Yii::t('app','About'), 'url'=>array('about')),
			array('label'=>Yii::t('app','Bag Report'), 'url'=>array('bag')),
		)),
				//*/		
		//array('label'=>Yii::t('app','Logout ('.Yii::app()->user->name.')'), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
		//array('label'=>Yii::t('app','Logout ('.Yii::app()->user->name.')'), 'url'=>'0','items'=>array()),
		
		
    );
		
		}
                
		$menu1=array();
		foreach($menu as $key=>$value){
			$menu1[]=array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>array($value),
			);
		}

		//$this->widget('zii.widgets.CMenu',array('items'=>$menu)); 

$this->widget('bootstrap.widgets.TbMenu', array('items'=>$menu,'htmlOptions'=>array('class'=>'navbar-nav')));
//'collapse'=>true
//'fixed'=>false
//'fluid'=>true

 

?>
       </div>
	</nav>
    
        <div id="left">
            <?php if(!Yii::app()->user->isGuest){
			
                //array('label'=>Yii::t('app','Logout'), 'url'=>array('/site/Logout')),
                ?>
            
            <div class="media user-media hidden-phone">
                <a class="user-link" href="">
                    <img class="media-object img-polaroid user-img" alt="" src="<?php echo Yii::app()->createAbsoluteUrl('/assets/img/user.gif');?>">
                    <span class="label user-label">16</span>
                </a>
                <div class="media-body hidden-tablet">
                    <h5 class="media-heading"><?php echo Yii::app()->user->fname." ".Yii::app()->user->lname; ?></h5>
                    <ul class="unstyled user-info">
                        <li>
                            <a href=""><?php echo Yii::app()->user->username; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/Logout');?>"><?php echo Yii::t('app','Logout');?></a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('/company/index');?>"><?php echo Yii::t('app','Change Company');?></a>
                        </li>
                        
                        <!--<li>
                            Last Access :
                            <br>
                            
                                <i class="icon-calendar"></i>
                                16 Mar 16:32
                        </li>-->
                    </ul>
                </div>
            </div>
            
            <?php 
            
		}
            
            ?>
            <?php
		//$this->beginWidget('zii.widgets.CPortlet', array(
		//	'title'=>'Operations',
               //         'htmlOptions'=>array('class'=>'unstyled accordion collapse in'),
		//));
                //$this->widget('sideNavBar', array('items'=>$this->menu,'id'=>'menu'));
            
            $this->widget('zii.widgets.CMenu', array('items'=>$this->menu,'id'=>'menu','htmlOptions'=>array('class'=>'unstyled accordion collapse in'),));
            
		
		//$this->endWidget();
	?>
            
        </div>
	<div id="content" class="">
            

            <div class="container-fluid outer">
                
                
            
                
     <?php $this->widget('bootstrap.widgets.TbAlert'); ?>           
                
                
            <?php //if(isset($this->breadcrumbs)):?>
                    <?php //$this->widget('zii.widgets.CBreadcrumbs', array(
                    //	'links'=>$this->breadcrumbs,
                    //)); ?><!-- breadcrumbs -->
            <?php //endif?>
                    
                    
               
       
                      <?php echo $content; ?>

                    
            <?php //echo $content; ?>
            </div>
        </div>
	<div id="footer">
		מונע על ידי מחשוב מהיר<br>
		נכתב על ידי אדם בן חור<br>
		<a href="http://www.speedcomp.co.il/">www.speedcomp.co.il</a>
	</div>

</div><!-- page -->

</body>
</html>
