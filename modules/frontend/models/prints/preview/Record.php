<?php
namespace app\modules\frontend\models\prints\preview;

use app\enums\CaseStatus as Status;
use app\modules\frontend\models\base\RecordFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\QueryInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Record extends \app\modules\frontend\models\base\Record
{
    public $ids;

    public function search($ids)
    {
        $query = $this->find()
            ->select([
                'id' => 'record.id',
                'license' => 'record.license',
                'latitude' => 'location.lat_dd',
                'longitude' => 'location.lng_dd',
                'state_id' => 'record.state_id',
                'infraction_date' => 'record.infraction_date',
                'created_at' => 'record.created_at',
                'status_id' => 'record.status_id',
                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
            ])
            ->from(['record' => static::tableName()])
            ->joinWith([
                'owner' => function (ActiveQuery $query) {
                    $query->from('Owner owner');
                },
                'location' => function (ActiveQuery $query) {
                    $query->from('Location location');
                },
            ]);

        if (!empty($ids)) {
            $query->andFilterWhere(['in', 'record.id', $ids]);
        }

        return new ActiveDataProvider(['query' => $query]);
    }

}