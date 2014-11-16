<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class OutcomeController extends RightsController{
    public function actionCreate($type=0){
        $model=new FormOutcome();
        if ($type == 1) {
            $model->account_id = Yii::app()->user->settings["company.acc.payvat"];
        }
        if ($type == 2) {
            $model->account_id = Yii::app()->user->settings["company.acc.natinspay"];
        }


        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation($model);
        if (isset($_POST['FormOutcome'])) {
            $model->attributes = $_POST['FormOutcome'];
            if($model->transaction())
                Yii::app()->user->setFlash('success', Yii::t('app','transaction Success'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'outcome-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

?>
