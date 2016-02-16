<?php
namespace app\modules\frontend\models\base;

interface RecordFilter
{
    const FILTER_CREATED_ALL = 0;
    const FILTER_CREATED_AT_TODAY = 1;
    const FILTER_CREATED_AT_LAST_3_DAYS = 2;
    const FILTER_CREATED_AT_LAST_X_DAYS = 3;

    const FILTER_STATUS_DISABLED = 0;
    const FILTER_STATUS_INCOMPLETE = 1;
    const FILTER_STATUS_COMPLETE = 2;
    const FILTER_STATUS_VIEWED = 3;
    const FILTER_STATUS_DETERMINED = 4;
    const FILTER_STATUS_PRINT_P1 = 5;
    const FILTER_STATUS_PRINT_P2 = 6;
    const FILTER_STATUS_PENDING_PRINT_P1 = 7;

    const FILTER_SMART_SEARCH_EXACT = 1;
    const FILTER_SMART_SEARCH_PARTIAL = 2;
    const FILTER_SMART_SEARCH_WILDCARD = 3;

    const MAX_DAYS_AGO = 999;

    /**
     * @return array
     */
    public function getAvailableStatuses();

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