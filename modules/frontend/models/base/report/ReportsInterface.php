<?php

namespace app\modules\frontend\models\base\report;

interface ReportsInterface
{
    /**
     * @return array
     */
    public function getCreatedAtFilters();

    /**
     * @return array
     */
    public function getGroupByFilters();


}