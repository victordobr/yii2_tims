<?php

namespace app\modules\frontend\controllers;

use Yii;
use app\models\Evidence;
use app\modules\frontend\models\search\PoliceCase as PoliceCaseSearch;
use \app\modules\frontend\base\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EvidenceController implements the CRUD actions for Evidence model.
 */
class CasesController extends Controller
{

    /**
     * Lists all Evidence models.
     * @return mixed
     */
    public function actionSearch()
    {
        $model = new PoliceCaseSearch;
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
