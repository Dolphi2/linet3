<?php

/* * *********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 * ********************************************************************************** */

class m301119_050115_0026 extends CDbMigration {

    public function up() {

        CFileHelper::removeDirectory(Yii::app()->basePath."/components/dashboard/");
        CFileHelper::removeDirectory(Yii::app()->basePath."/../update/");
        CFileHelper::removeDirectory(Yii::app()->basePath."/../assets/lib/chosen/");
        
        $companys = Company::model()->findAll();      
        foreach ($companys as $company) {
            $this->alterColumn($company->prefix . 'itemCategories', "id", 'INT(11) NOT NULL AUTO_INCREMENT');
        }
    }

    public function down() {

        return true;
    }

}
