<?php
namespace app\modules\frontend\models\base;

interface RecordFilter
{
    /**
     * @return array
     */
    public function getCreatedAtFilters();

    /**
     * @param string $action
     * @return array
     */
    public function getStatusFilters($action);

    /**
     * @return array
     */
    public function getAuthorFilters();

    /**
     * @return array
     */
    public function getSmartSearchTypes();

    /**
     * @return array
     */
    public function getRecordStatuses();

}