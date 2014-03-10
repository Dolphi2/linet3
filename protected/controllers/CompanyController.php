<?php

class CompanyController extends RightsController
{
	public $defaultAction = 'index';
        public $layout='//layouts/clean';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex(){
            if(isset($_POST['Company'])){
                //if has access
                $database= Company::model()->findByPk((int)$_POST['Company']);
                Yii::app()->user->setState('Database',$database );
                Yii::app()->user->setState('Company',1);
                //redirect
                
                Yii::app()->end();

            }

            if(Yii::app()->user->Company!=0){
                Yii::app()->user->setState('Company',0);
                Yii::app()->user->Company=0;

                $this->redirect('company');
                Yii::app()->end();
            }

            $model=new Company('search');
            $model->unsetAttributes();  // clear any default values
            $this->render('index',array('model'=>$model,));
	}

	
        public function actionDelete(){
            
	}
        
        
        public function actionCreate(){
		$model=new Company;
		$model->string=Yii::app()->dbMain->connectionString;
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $model->prefix=substr(str_shuffle($chars),0,4)."_";
                
		
                if($model->save()){
                    $database= Company::model()->findByPk($model->id);
                    Yii::app()->user->setState('Database',$database );
                    Yii::app()->user->setState('Company',$model->id);
                     //redierct to settings.
                    $this->redirect(array('settings/admin')); 
		}
                
		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        
        public function actionUpdate($id){
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company'])){
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        
        public function loadModel($id){
		$model= Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
  