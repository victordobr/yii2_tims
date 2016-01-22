<?php

namespace app\modules\admin\models;

class Setting extends \pheme\settings\models\Setting
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'type' => \Yii::t('app', 'Type'),
            'section' => \Yii::t('app', 'Section'),
            'key' => \Yii::t('app', 'Key'),
            'value' => \Yii::t('app', 'Value'),
            'active' => \Yii::t('app', 'Active'),
            'created' => \Yii::t('app', 'Created'),
            'modified' => \Yii::t('app', 'Modified'),
        ];
    }
}