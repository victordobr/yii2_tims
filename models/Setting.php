<?php

namespace app\models;

use pheme\settings\Module;

class Setting extends \pheme\settings\models\Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section', 'key', 'value'], 'required'],
            [['value'], 'string'],
            [['section', 'key'], 'string', 'max' => 255],
            [
                ['key'],
                'unique',
                'targetAttribute' => ['section', 'key'],
                'message' =>
                    Module::t('settings', '{attribute} "{value}" already exists for this section.')
            ],
            [['type', 'created', 'modified'], 'safe'],
            [['active'], 'boolean'],
        ];
    }
}