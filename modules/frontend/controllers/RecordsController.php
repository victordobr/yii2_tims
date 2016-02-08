<?php

namespace app\modules\frontend\controllers;

use app\enums\Role;
use app\modules\frontend\controllers\records\DeactivateAction;
use app\modules\frontend\controllers\records\RequestDeactivationAction;
use app\modules\frontend\controllers\records\ReviewAction;
use app\modules\frontend\controllers\records\SearchAction;
use app\modules\frontend\controllers\records\upload\ChunkUploadAction;
use app\modules\frontend\controllers\records\upload\HandleAction;
use app\modules\frontend\controllers\records\upload\UploadAction;
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
        return [
            'search' => SearchAction::className(),
            'review' => ReviewAction::className(),
            'RequestDeactivation' => RequestDeactivationAction::className(),
            'deactivate' => DeactivateAction::className(),
            'upload' => UploadAction::className(),
            'handle' => HandleAction::className(),
            'chunk-upload' => ChunkUploadAction::className(),
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['upload', 'chunkUpload', 'handle', 'search', 'review', 'RequestDeactivation', 'deactivate'],
                'rules' => [
                    [
                        'actions' => ['review'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                            Role::ROLE_POLICE_OFFICER,
                            Role::ROLE_POLICE_OFFICER_SUPERVISOR,
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['RequestDeactivation'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['deactivate'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['upload', 'chunkUpload', 'handle', 'search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
