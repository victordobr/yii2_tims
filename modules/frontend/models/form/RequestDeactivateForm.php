<?php
namespace app\modules\frontend\models\form;

use Yii;
use yii\base\Model;
use app\enums\Reasons;

class RequestDeactivateForm extends Model
{
    public $code;
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['description'], 'required', 'when' => function($model) {
                return $model->code == Reasons::OTHER;
            }],
            [['code'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Reason'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

}
