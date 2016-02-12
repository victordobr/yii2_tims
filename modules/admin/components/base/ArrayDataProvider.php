<?php

namespace app\modules\admin\components\base;

/**
 * ArrayDataProvider implements a data provider based on a data array.
 */
class ArrayDataProvider extends \yii\data\ArrayDataProvider
{
    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (($models = $this->allModels) === null) {
            return [];
        }

        if (($sort = $this->getSort()) !== false) {
            $models = $this->sortModels($models, $sort);
        }

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
        }

        return $models;
    }

    /**
     * Sorts the data models according to the given sort definition
     * @param array $models the models to be sorted
     * @param Sort $sort the sort definition
     * @return array the sorted data models
     */
    protected function sortModels($models, $sort)
    {
        return $models;
    }
}
