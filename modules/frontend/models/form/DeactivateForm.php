<?php
namespace app\modules\frontend\models\form;

use Yii;
use yii\base\Model;

class DeactivateForm extends Model
{
    public $code;
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code', 'description'], 'required'],
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
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

}
