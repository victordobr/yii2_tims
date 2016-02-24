<?php

namespace app\modules\frontend\controllers;

use app\enums\Role;
use app\modules\frontend\controllers\records\action\ChangeDeterminationAction;
use app\modules\frontend\controllers\records\action\ConfirmQcAction;
use app\modules\frontend\controllers\records\action\DeactivateAction;
use app\modules\frontend\controllers\records\action\MakeDeterminationAction;
use app\modules\frontend\controllers\records\action\RejectQcAction;
use app\modules\frontend\controllers\records\action\RequestDeactivationAction;
use app\modules\frontend\controllers\records\action\SendToPrintAction;
use app\modules\frontend\controllers\records\PreviewAction;
use app\modules\frontend\controllers\records\PrintAction;
use app\modules\frontend\controllers\records\SearchAction;
use app\modules\frontend\controllers\records\action\UpdateAction;
use app\modules\frontend\controllers\records\UploadAction;
use app\modules\frontend\controllers\records\upload\ChunkUploadAction;
use app\modules\frontend\controllers\records\upload\HandleAction;
use app\modules\frontend\controllers\records\ViewAction;
use Yii;

use yii\filters\AccessControl;
use \app\modules\frontend\base\Controller;

/**
 * RecordsController implements the actions for Record model.
 */
class RecordsController extends Controller
{

    public function actions()
    {
        $user = Yii::$app->user;
        $request = Yii::$app->request;

        return [

            // upload
            'upload' => UploadAction::className(),
            'handle' => HandleAction::className(),
            'chunk-upload' => ChunkUploadAction::className(),

            // search
            'SearchList' => [
                'class' => SearchAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'SearchView' => ViewAction::className(),

            // review
            'ReviewList' => [
                'class' => SearchAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'ReviewView' => ViewAction::className(),

            // print
            'PrintList' => [
                'class' => SearchAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'PrintView' => PrintAction::className(),
            'PrintPreview' => [
                'class' => PreviewAction::className(),
                'ids' => $request->get('ids'),
            ],
            'QcList' => [
                'class' => SearchAction::className(),
                'attributes' => $request->get('Record'),
                'qc' => true,
            ],
            'SendToPrint' => [
                'class' => SendToPrintAction::className(),
                'ids' => $request->post('ids'),
                'user_id' => $user->id,
            ],
            'ConfirmQc' => [
                'class' => ConfirmQcAction::className(),
                'ids' => $request->post('ids'),
                'user_id' => $user->id,
            ],
            'RejectQc' => [
                'class' => RejectQcAction::className(),
                'ids' => $request->post('ids'),
                'user_id' => $user->id,
            ],

            // update
            'UpdateList' => [
                'class' => SearchAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'UpdateView' => ViewAction::className(),

            // actions
            'update' => [
                'class' => UpdateAction::className(),
                'attributes' => $request->post('Record'),
            ],
            'RequestDeactivation' => RequestDeactivationAction::className(),
            'deactivate' => DeactivateAction::className(),
            'MakeDetermination' => [
                'class' => MakeDeterminationAction::className(),
                'attributes' => $request->post('MakeDeterminationForm'),
            ],
            'ChangeDetermination' => [
                'class' => ChangeDeterminationAction::className(),
                'attributes' => $request->post('ChangeDeterminationForm'),
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'upload',
                    'chunkUpload',
                    'handle',

                    'SearchList',
                    'SearchView',

                    'ReviewList',
                    'ReviewView',

                    'PrintList',
                    'PrintView',
                    'PrintPreview',
                    'QcList',
                    'SendToPrint',
                    'ConfirmQc',
                    'RejectQc',

                    'UpdateList',
                    'UpdateView',
                    'update',

                    'RequestDeactivation',
                    'deactivate',
                    'MakeDetermination',
                    'ChangeDetermination',
                ],
                'rules' => [
                    [
                        'actions' => ['SearchList', 'SearchView'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_POLICE_OFFICER,
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['ReviewList', 'ReviewView'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_POLICE_OFFICER,
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['PrintList', 'PrintView', 'PrintPreview', 'QcList', 'SendToPrint', 'ConfirmQc', 'RejectQc'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['UpdateList', 'UpdateView'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['RequestDeactivation'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['deactivate'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['MakeDetermination'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_POLICE_OFFICER,
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER,
                        ],
                    ],
                    [
                        'actions' => ['ChangeDetermination'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER,
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_ROOT_SUPERUSER,
                        ],
                    ],
                    [
                        'actions' => ['upload', 'chunkUpload', 'handle'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
