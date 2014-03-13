<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return CMap::mergeArray(
	include(dirname(__FILE__).'/install.php'),
        array(
            'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
            'name'=>'Linet 3.0',
            //'theme'=>'fancy',
            'sourceLanguage'=>'en',
            // preloading 'log' component
            'preload'=>array('log'),
            
            'localeDataPath'=>'protected/i18n/data/',
            'defaultController' => 'company',
            'onBeginRequest' => array('Linet3', 'beginRequest'),	

            // autoloading model and component classes
            'import'=>array(
                    'application.models.*',
                    'application.components.*',
                    'application.components.dashboard.*',
                    'application.modules.rights.*',
                    'application.modules.rights.components.*',
                    //'application.extensions.debugtoolbar.*',
            ),
            'modules'=>array(
                    //'auth'=>array(),
                    'rights'=>array(
                            'debug'=>true,
                            //'install'=>true,
                            'enableBizRuleData'=>true,
                            //'superuserName'=>'admin',
                    ),
                    'eav'=>array(),
                    'forum'=>array(),
                    // uncomment the following to enable the Gii tool
                    'user' => array(
                            'debug'=>True,
                    ),
                    'gii'=>array(
                            'class'=>'system.gii.GiiModule',
                            'password'=>'VBy7t6r5',
                            'ipFilters'=>array('172.22.102.12','::24'),
                            'generatorPaths'=>array(
                                    'bootstrap.gii',
                            ),
                    ),

            ),

            // application components
            'components'=>array(
                    //'localtime'=>array(
                    //    'class'=>'LocalTime',
                    //),
                    'Paypal' => array(
                            'class'=>'application.components.Paypal',

                    ),
                    'session' => array (
                            'autoStart' => True,
                            'class' => 'system.web.CDbHttpSession',
                            'connectionID' => 'dbSession',
                            'sessionTableName' => 'sessionStore',
                    ),
                    'bootstrap'=>array(
                            'class'=>'bootstrap.components.Bootstrap',
                    ),
                    //'cache'=>array(
                            //'class'=>'CApcCache',
                    //),
                    'user'=>array(
                            //'class' => 'RLinUser',
                            'class'=>'RWebUser',//rights
                            'allowAutoLogin'=>true,
                            //'loginUrl' => array('//user/user/login'),

                            // enable cookie-based authentication
                            //'allowAutoLogin'=>true,
                    ),

                    'authManager'=>array(
                            'class'=>'RDbAuthManager',
                            'connectionID'=>'db',
                            'defaultRoles'=>array('Guest'),
                            'itemTable'=>'{{AuthItem}}',
                            'itemChildTable'=>'{{AuthItemChild}}',
                            'assignmentTable'=>'{{AuthAssignment}}',
                            'rightsTable'=>'{{Rights}}',
                    ),

                    'ePdf' => array(
                        'class'         => 'ext.yii-pdf.EYiiPdf',
                        'params'        => array(
                            'mpdf'     => array(
                                'librarySourcePath' => 'ext.yii-pdf.mpdf57.*',
                                'constants'         => array(
                                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                                ),
                                'class'=>'mpdf',
                            )
                        )
                    ),//ePdf

                    /* 'authManager'=>array(
                'class'=>'CDbAuthManager',
                'connectionID'=>'db',
            ),//*/
                    /*'authManager' => array(
                            'behaviors' => array(
                                    'auth' => array(
                                            'class' => 'auth.components.AuthBehavior',
                                            'admins'=>array('adam'), // users with full access
                                            ),
                                    ),

                            ),
                    'user' => array(
                            'class' => 'auth.components.AuthWebUser',
                    ),//*/
                    // uncomment the following to enable URLs in path-format
                    'urlManager' => array(
                            'urlFormat'=>'path',
                            'showScriptName'=>false,
                            'rules' => array(
                                    '' => 'company/index',
                                    //'minify/<group:[^\/]+>'=>'minify/index',
                                    //'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                    '<controller:\w+>/create/<type:\d+>'=>'<controller>/create',//mainly for doc, acc,outcome creating
                                    //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                    //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                                    '<controller:\w+>/index/<type:\d+>'=>'<controller>/index',
                                    'install/<step:\d+>'=>'install/index',
                                    'docs/view/<doctype:\d+>/<docnum:\d+>'=>'docs/view',
                                    'docs/view/<id:\d+>'=>'docs/view',
                                
                                    'download/<id:\d+>'=>'data/download',
                                    'download/<company:\w+>/<hash:\d+>'=>'data/downloadpublic',
                            ),
                    ),
                    //'clientScript'=>array(
                    //    'class'=>'application.extensions.CClientScriptMinify',
                    //    'minifyController'=>'../minify',
                    //),		
                    /*
                    'urlManager'=>array(
                            'urlFormat'=>'path',
                            'rules'=>array(
                                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            ),
                    ),
                    */
                    /*'db'=>array(
                            //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
                            'connectionString' => 'sqlite:/var/www/yii/demos/new/protected/data/testdrive.db',
                            'tablePrefix' => '',
                    ),*/
                    // uncomment the following to use a MySQL database

                    

                    'errorHandler'=>array(
                            // use 'site/error' action to display errors
                'errorAction'=>'site/error',
            ),
                    'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                            array(
                                'class'=>'CWebLogRoute',
                                'levels'=>'info,error,warning',
                                //'levels'=>'trace, info, error, warning, application',
                                'categories'=>'system.db.*, application',
                                'filter' => array(
                                    'class' => 'CLogFilter',
                                    'prefixSession' => true,
                                    'prefixUser' => false,
                                    'logUser' => false,
                                    'logVars' => array(),
                                ),
                            ),
                            array(
                                'class'=>'CFileLogRoute',
                                'levels'=>'trace, info, error, warning',
                                //'categories'=>'system.*',
                                    //'categories'=>'*',
                            ),
                                    
                            /*array(
                                'class'=>'CEmailLogRoute',
                                'levels'=>'error, warning',
                                'emails'=>'adam@speedcomp.co.il',
                            ),*/


                        ),
                ),//end log
            ),

            // application-level parameters that can be accessed
            // using Yii::app()->params['paramName']
            'params'=>array(
                    // this is used in contact page
                    'adminEmail'=>'adam@speedcomp.co.il',
                    //'tablePrefix' => ''
            ),
    )//end main
                );//end merge
