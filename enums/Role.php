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
    const ROLE_OPERATION_MANAGER = 'OperationsManager';
    const ROLE_ACCOUNTS_RECONCILIATION = 'AccountsReconciliation';
    const ROLE_SYSTEM_ADMINISTRATOR = 'SystemAdministrator';
    const ROLE_ROOT_SUPERUSER = 'RootSuperuser';
}
