<?php

namespace app\modules\frontend\controllers;

use app\components\RbacUser;
use app\enums\Role;
use app\modules\frontend\controllers\reports\OverallSummaryDashboardAction;
use app\modules\frontend\controllers\reports\ReportViewAction;
use app\modules\frontend\controllers\reports\ViolationsBySchoolBusAction;
use Yii;
use app\enums\ReportType;
use app\modules\frontend\controllers\reports\IndexAction;
use app\modules\frontend\controllers\reports\ViolationsByDateAction;
use \app\modules\frontend\base\Controller;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/**
 * RecordsController implements the actions for Record model.
 */
class ReportsController extends Controller
{

    public function actions()
    {
        $request = Yii::$app->request;

        return [
            'overall-summary-dashboard' => [
                'class' =>  OverallSummaryDashboardAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'violations-by-date' => [
                'class' =>  ViolationsByDateAction::className(),
                'attributes' => $request->get('Record'),
            ],
            'violations-by-school-bus' => [
                'class' =>  ViolationsBySchoolBusAction::className(),
                'attributes' => $request->get('Record'),
            ],




            'report-view' => [
                'class' =>  ReportViewAction::className(),
                'attributes' => $request->get('Record'),
            ],


        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'overall-summary-dashboard',
                    'violations-by-date',
                    'violations-by-school-bus',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'overall-summary-dashboard',
                            'violations-by-date',
                            'violations-by-school-bus',
                        ],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_ACCOUNTS_RECONCILIATION,
                            Role::ROLE_ROOT_SUPERUSER,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $report_types = RbacUser::getReportTypesByRole();

        $allItems = self::createItems($report_types);

        foreach ($allItems as $parent_id => $item) {
            $providers[] = new ArrayDataProvider([
                'Models' => $item,
                'id' => $parent_id,
                'pagination' => false,
            ]);
        }

        $class = 'col-md-' . 12/count($report_types);

        return $this->render('reportsList', [
            'providers' => $providers,
            'class' => $class,
        ]);
    }

    /**
     * Create a group with reports link
     * @param $report_types the ID of group available reports for current user role
     * @return mixed
     */
    public static function createItems($report_types)
    {
        $list_url = ReportType::listUrl();
        foreach (ReportType::getHierarchy() as $parent_id => $ids) {
            if (in_array($parent_id, $report_types)) {
                $list = [];
                foreach ($ids as $id) {
                    $list[$id]['id'] = $id;
                    $list[$id]['url'] = Html::a(ReportType::labelById($id), [$list_url[$id]], ['class' => ($list_url[$id]) ? '' : 'disabled']);
                }
                $list_arr[$parent_id] = $list;
            }
        }
        return $list_arr;
    }

}
