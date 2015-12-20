<?php

/* * *********************************************************************************
 * The contents of this file are subject to the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * ("License"); You may not use this file except in compliance with the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 * ********************************************************************************** */
namespace app\controllers;

use Yii;
use app\components\RightsController;
use app\models\MailTemplate;
use app\models\Docs;
use app\models\Accounts;

class MailTemplateController extends RightsController {

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = MailTemplate::findOne($id);

        return $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionJson() {
        $obj = $_POST['MailTemplate']['obj'];
        $type = $_POST['MailTemplate']['type'];
        $id = $_POST['MailTemplate']['id'];
        $model = MailTemplate::find()->where(['entity_type' => $obj, 'entity_id' => $type])->one();
        if(!$model)
            $model=new MailTemplate;



        $data = $obj::findOne($id);



        $model->templateRplc($data);
        echo \yii\helpers\Json::encode(array($model));
        /*
          return $this->render('view', array(
          'model' => $model,
          )); */
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MailTemplate;

        if ($model->load(Yii::$app->request->post())){
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        if ($model->load(Yii::$app->request->post())){
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        if (Yii::$app->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new \yii\web\HttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MailTemplate');
        return $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MailTemplate();
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['MailTemplate']))
            $model->attributes = $_GET['MailTemplate'];

        return $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = MailTemplate::findOne($id);
        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
