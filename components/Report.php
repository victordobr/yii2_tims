<?php
namespace app\components;

use app\base\Module;
use Yii;
use app\enums\report\ReportType;
use app\enums\Role;
use yii\base\Component;
use app\enums\report\ReportStatus as Status;
use app\enums\report\ReportGroup;

/**
 * Report component to prepare for Report queries
 */
class Report extends Component
{
    const SQL_SELECT_AUTHOR = 'CONCAT_WS(", ", User.last_name, User.first_name)';

    public static function createQuerySelect($filter_group_id)
    {
        $statuses_ids = self::getAvailableStatuses($filter_group_id);

        switch (true) {
            case in_array($filter_group_id, [ReportGroup::GROUP_DAY, ReportGroup::GROUP_BUS_NUMBER]):

                $group_attribute = self::getGroupAttribute($filter_group_id);

                foreach ($statuses_ids as $id) {
                    $status_arr['status_' . $id] = 'sum(record.status_id=' . $id . ')';
                }
                return [$group_attribute => 'record.' . $group_attribute] + $status_arr;
            case in_array($filter_group_id, [ReportGroup::GROUP_VIDEO_ANALYST, ReportGroup::GROUP_POLICE_OFFICER, ReportGroup::GROUP_PRINT_OPERATOR]):

                foreach ($statuses_ids as $id) {
                    $status_arr['status_' . $id] = 'sum(record.status_code=' . $id . ')';
                }
                return ['author' => self::SQL_SELECT_AUTHOR] + $status_arr;
        }
    }

    public static function createQueryDetailSelect($page_filter_id)
    {
        $statuses_ids = self::getAvailableStatuses($page_filter_id);

        foreach ($statuses_ids as $id) {
            $status_arr['status_' . $id] = 'sum(record.status_code=' . $id . ')';
        }

        return ['created_at' => 'record.created_at'] + $status_arr;
    }

    public static function createViewData($filter_group_id)
    {
        $groups_list = Status::listGroupsReport();

        $statuses_list = array_intersect_key(Status::listStatusesReport(), array_flip(self::getAvailableStatuses($filter_group_id)));

        $groups[] = [
            'content' => ReportGroup::labelById($filter_group_id),
            'colspan' => 1,
        ];
        $statuses = [];
        foreach(Status::structureStatusesReport() as $key => $value) {
            if (in_array($key, self::getAvailableGroups($filter_group_id))) {
                $groups[$key] = [
                    'content' => $groups_list[$key],
                    'colspan' => count($value),
                ];
                foreach($value as $item)
                    $statuses[$item] = $statuses_list[$item];
            }
        }

        return [
            $groups,
            $statuses,
        ];
    }

    public static function getUrlById($id)
    {
        return ReportGroup::listUrlSummary()[$id];
    }

    public static function getIdByUrl($url)
    {
        return array_search($url, ReportGroup::listUrlSummary());
    }

    public static function getIdByUrlDetail($url)
    {
        return array_search($url, ReportGroup::listUrlDetail());
    }

    public static function getGroupAttribute($id)
    {
        return ReportGroup::listGroupAttribute()[$id];
    }

    public static function getGroupTableAttribute($id)
    {
        switch(true) {
            case in_array($id, [ReportGroup::GROUP_DAY, ReportGroup::GROUP_BUS_NUMBER]):
                return ReportGroup::listGroupAttribute()[$id];
            case in_array($id, [ReportGroup::GROUP_VIDEO_ANALYST, ReportGroup::GROUP_POLICE_OFFICER, ReportGroup::GROUP_PRINT_OPERATOR]):
                return 'author';
        }
    }

    public static function getAvailableGroups($filter_group_id)
    {
        switch($filter_group_id){
            case ReportGroup::GROUP_POLICE_OFFICER:
                return [
                    Status::GROUP_REVIEWS,
                    Status::GROUP_PRINT_MAIL,
                    Status::GROUP_PAYMENT,
                ];
            case ReportGroup::GROUP_PRINT_OPERATOR:
                return [
                    Status::GROUP_PRINT_MAIL,
                    Status::GROUP_PAYMENT,
                ];
            default:
                return [
                    Status::GROUP_UPLOADS,
                    Status::GROUP_REVIEWS,
                    Status::GROUP_PRINT_MAIL,
                    Status::GROUP_PAYMENT,
                ];
        }
    }

    public static function getAvailableStatuses($filter_group_id)
    {
        switch($filter_group_id){
            case ReportGroup::GROUP_POLICE_OFFICER:
                return [
                    Status::VIEWED_RECORD, //2010
                    Status::APPROVED_RECORD, //2020
                    Status::REJECTED_RECORD, //2030

                    Status::DMV_DATA_RETRIEVED_COMPLETE, //3020
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL, //3030
                    Status::PRINTED_P1, //4010
                    Status::PRINTED_P2, //4040

                    Status::PAID, //5030
                    Status::COURT_DATE_REQUESTED, //5040
                ];
            case ReportGroup::GROUP_PRINT_OPERATOR:
                return [
                    Status::DMV_DATA_RETRIEVED_COMPLETE, //3020
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL, //3030
                    Status::PRINTED_P1, //4010
                    Status::PRINTED_P2, //4040

                    Status::PAID, //5030
                    Status::COURT_DATE_REQUESTED, //5040
                ];
            default:
                return [
                    Status::COMPLETE, //1020
                    Status::DEACTIVATED_RECORD, //1040

                    Status::VIEWED_RECORD, //2010
                    Status::APPROVED_RECORD, //2020
                    Status::REJECTED_RECORD, //2030

                    Status::DMV_DATA_RETRIEVED_COMPLETE, //3020
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL, //3030
                    Status::PRINTED_P1, //4010
                    Status::PRINTED_P2, //4040

                    Status::PAID, //5030
                    Status::COURT_DATE_REQUESTED, //5040
                ];
        }
    }

    /**
     * @return array
     */
    public static function getReportTypesByRole()
    {
        switch (Yii::$app->user->role->name) {
            case Role::ROLE_OPERATIONS_MANAGER:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::OPERATIONAL_REPORTS,
                ];
            case Role::ROLE_ACCOUNTS_RECONCILIATION:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::FINANCIAL_REPORTS,
                ];
            case Role::ROLE_ROOT_SUPERUSER:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::OPERATIONAL_REPORTS,
                    ReportType::FINANCIAL_REPORTS,];
            default:
                return [];
        }
    }

}