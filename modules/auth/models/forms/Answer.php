<?php

namespace app\modules\auth\models\forms;

use Yii,
    yii\base\Model;

/**
 * Question form for validate.
 * @package app\modules\auth\models\forms
 */
class Answer extends Model
{
    /** @var string $answer */
    public $answer;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['answer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer'   => Yii::t('app', 'Answer'),
        ];
    }
}
