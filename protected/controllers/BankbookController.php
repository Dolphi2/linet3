<?php

class BankbookController extends RightsController{
    
    
    
    public function actionAdmin(){
		$model=new Bankbook('search');
		$model->unsetAttributes();  // clear any default values
		//if(isset($_POST['Bankbook']))
		//	$model->attributes=$_GET['Currates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
    public function actionAjax(){
            $model=new Bankbook('search');
            //$model->account_id=$account_id;
            if(isset($_POST['Bankbook']))
                    $model->attributes=$_POST['Bankbook'];
            $this->renderPartial('ajax',array( 'model'=>$model,   ));
    }
    
    public function actionDeposit(){
        
    }
}
