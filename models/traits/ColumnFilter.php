<?php
namespace app\models\traits;

use \app\base\ActiveRecord;
use \Yii;
use \yii\db\Query;

/**
 * Class ColumnFilter for universal column filters
 * @package app\models\traits
 */
trait ColumnFilter
{
    /**
     * Gets list of suggestions
     * @param string $field
     * @param string $value
     * @param int $limit
     * @param callable $callable
     * @param callable $auxConditions
     * @return array
     */
    public function getSuggestions($field, $value, $limit, $user_id, callable $callable = null, callable $auxConditions = null)
    {
        if (!($this instanceof ActiveRecord)) {
            return null;
        }
        $suggestionTablePseudo = strtolower(static::tableName());
        $query = new Query();
        if (!is_null($callable)) {
            $query = call_user_func_array($callable, [$query, $field, $value, $limit]);
        } else {
            $query->select([
                Yii::$app->params['common.autoсomplete.display.key'] => "DISTINCT(`{$suggestionTablePseudo}`.`{$field}`)",
            ])
                ->from([$suggestionTablePseudo => static::tableName()]);
            if (!is_null($auxConditions))
            {
                $query = call_user_func_array($auxConditions, [$query, $field, $value, $limit]);
            }
            $query->andWhere("`{$suggestionTablePseudo}`.`{$field}` LIKE :value", ['value' => "%{$value}%"])
                ->limit($limit);
        }
        $query->each();
        $command = $query->createCommand();

        return (object)$command->queryAll();

    }
}