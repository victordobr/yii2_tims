<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * Role Enum
 * @package app\enums
 * @author Alex Makhorin
 */
class Role extends Enum
{
    const ROLE_VIDEO_ANALYST = 'VideoAnalyst';
    const ROLE_VIDEO_ANALYST_SUPERVISOR = 'VideoAnalystSupervisor';
    const ROLE_POLICE_OFFICER = 'PoliceOfficer';
    const ROLE_POLICE_OFFICER_SUPERVISOR = 'PoliceOfficerSupervisor';
    const ROLE_PRINT_OPERATOR = 'PrintOperator';
    const ROLE_OPERATIONS_MANAGER = 'OperationsManager';
    const ROLE_ACCOUNTS_RECONCILIATION = 'AccountsReconciliation';
    const ROLE_SYSTEM_ADMINISTRATOR = 'SystemAdministrator';
    const ROLE_ROOT_SUPERUSER = 'RootSuperuser';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::ROLE_VIDEO_ANALYST  => Yii::t('app', 'Video Analyst'),
            self::ROLE_VIDEO_ANALYST_SUPERVISOR  => Yii::t('app', 'Video Analyst Supervisor'),
            self::ROLE_POLICE_OFFICER  => Yii::t('app', 'Police Officer'),
            self::ROLE_POLICE_OFFICER_SUPERVISOR  => Yii::t('app', 'Police Officer Supervisor'),
            self::ROLE_PRINT_OPERATOR  => Yii::t('app', ' Print Operator'),
            self::ROLE_OPERATIONS_MANAGER  => Yii::t('app', 'Operations Manager'),
            self::ROLE_ACCOUNTS_RECONCILIATION => Yii::t('app', 'Accounts/Reconciliation'),
            self::ROLE_SYSTEM_ADMINISTRATOR => Yii::t('app', 'System Administrator'),
            self::ROLE_ROOT_SUPERUSER => Yii::t('app', 'Root/Superuser'),
        ];
    }
}
