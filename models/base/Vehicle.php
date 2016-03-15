<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Vehicle".
 *
 * @property integer $id
 * @property string $tag
 * @property integer $state
 * @property string $make
 * @property string $model
 * @property string $year
 * @property string $color
 * @property integer $owner_id
 *
 * @property Owner $owner
 */
class Vehicle extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Vehicle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag', 'state', 'make', 'model', 'year', 'color', 'owner_id'], 'required'],
            [['state', 'owner_id'], 'integer'],
            [['tag', 'make', 'model', 'year', 'color'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'state' => 'State',
            'make' => 'Make',
            'model' => 'Model',
            'year' => 'Year',
            'owner_id' => 'Owner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['id' => 'owner_id']);
    }
}
