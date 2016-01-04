<?php
/**
 * RBAC CLI
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * @author Andrey Prih <prihmail@gmail.com>
 */
class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		// Access Items

		$Upload = $auth->createPermission('Upload');
		$Upload->description = 'Upload files';
		$auth->add($Upload);

		$Search = $auth->createPermission('Search');
		$Search->description = 'Search';
		$auth->add($Search);

		$View = $auth->createPermission('View');
		$View->description = 'View';
		$auth->add($View);

		$ViewDeactivation = $auth->createPermission('ViewDeactivation');
		$ViewDeactivation->description = 'View Deactivation';
		$auth->add($ViewDeactivation);

		$RequestDeactivation = $auth->createPermission('RequestDeactivation');
		$RequestDeactivation->description = 'Request Deactivation';
		$auth->add($RequestDeactivation);

		$ApproveDeactivation = $auth->createPermission('ApproveDeactivation');
		$ApproveDeactivation->description = 'Approve Deactivation';
		$auth->add($ApproveDeactivation);

		$ViewDetermination = $auth->createPermission('ViewDetermination');
		$ViewDetermination->description = 'View Determination';
		$auth->add($ViewDetermination);

		$MakeDetermination = $auth->createPermission('MakeDetermination');
		$MakeDetermination->description = 'Make Determination';
		$auth->add($MakeDetermination);

		$ChangeDetermination = $auth->createPermission('ChangeDetermination');
		$ChangeDetermination->description = 'Change Determination';
		$auth->add($ChangeDetermination);

		$Print = $auth->createPermission('Print');
		$Print->description = 'Print';
		$auth->add($Print);

		$QControl = $auth->createPermission('QControl');
		$QControl->description = 'Quality Control';
		$auth->add($QControl);

		$Mail = $auth->createPermission('Mail');
		$Mail->description = 'Mail';
		$auth->add($Mail);

		$ViewUpdates = $auth->createPermission('ViewUpdates');
		$ViewUpdates->description = 'View Updates';
		$auth->add($ViewUpdates);

		$StatusUpdates = $auth->createPermission('StatusUpdates');
		$StatusUpdates->description = 'Status Updates';
		$auth->add($StatusUpdates);

		$DashboardReports = $auth->createPermission('DashboardReports');
		$DashboardReports->description = 'Dashboard Reports';
		$auth->add($DashboardReports);

		$SummaryReports = $auth->createPermission('SummaryReports');
		$SummaryReports->description = 'Summary Reports';
		$auth->add($SummaryReports);

		$OperationalReports = $auth->createPermission('OperationalReports');
		$OperationalReports->description = 'Operational Reports';
		$auth->add($OperationalReports);

		$FinancialReports = $auth->createPermission('FinancialReports');
		$FinancialReports->description = 'Financial Reports';
		$auth->add($FinancialReports);

		$PoliceOfficerProfilesMgmt = $auth->createPermission('PoliceOfficerProfilesMgmt');
		$PoliceOfficerProfilesMgmt->description = 'Police Officer Profiles Mgmt';
		$auth->add($PoliceOfficerProfilesMgmt);

		$UsersMgmt = $auth->createPermission('UsersMgmt');
		$UsersMgmt->description = 'Users Mgmt';
		$auth->add($UsersMgmt);

		$SystemConfiguration = $auth->createPermission('SystemConfiguration');
		$SystemConfiguration->description = 'System Configuration';
		$auth->add($SystemConfiguration);

		// Roles

		$VideoAnalyst = $auth->createRole('VideoAnalyst');
		$VideoAnalyst->description = 'Video Analyst';
		$auth->add($VideoAnalyst);
		$auth->addChild($VideoAnalyst, $Upload);
		$auth->addChild($VideoAnalyst, $Search);
		$auth->addChild($VideoAnalyst, $View);
		$auth->addChild($VideoAnalyst, $ViewDeactivation);
		$auth->addChild($VideoAnalyst, $RequestDeactivation);

		$VideoAnalystSupervisor = $auth->createRole('VideoAnalystSupervisor');
		$VideoAnalystSupervisor->description = 'Video Analyst Supervisor';
		$auth->add($VideoAnalystSupervisor);
		$auth->addChild($VideoAnalystSupervisor, $Upload);
		$auth->addChild($VideoAnalystSupervisor, $Search);
		$auth->addChild($VideoAnalystSupervisor, $View);
		$auth->addChild($VideoAnalystSupervisor, $ViewDeactivation);
		$auth->addChild($VideoAnalystSupervisor, $RequestDeactivation);
		$auth->addChild($VideoAnalystSupervisor, $ApproveDeactivation);

		$PoliceOfficer = $auth->createRole('PoliceOfficer');
		$PoliceOfficer->description = 'Police Officer';
		$auth->add($PoliceOfficer);
		$auth->addChild($PoliceOfficer, $Search);
		$auth->addChild($PoliceOfficer, $View);
		$auth->addChild($PoliceOfficer, $ViewDetermination);
		$auth->addChild($PoliceOfficer, $MakeDetermination);

		$PoliceOfficerSupervisor = $auth->createRole('PoliceOfficerSupervisor');
		$PoliceOfficerSupervisor->description = 'Police Officer Supervisor';
		$auth->add($PoliceOfficerSupervisor);
		$auth->addChild($PoliceOfficerSupervisor, $Search);
		$auth->addChild($PoliceOfficerSupervisor, $View);
		$auth->addChild($PoliceOfficerSupervisor, $ViewDetermination);
		$auth->addChild($PoliceOfficerSupervisor, $MakeDetermination);
		$auth->addChild($PoliceOfficerSupervisor, $ChangeDetermination);
		$auth->addChild($PoliceOfficerSupervisor, $PoliceOfficerProfilesMgmt);

		$PrintOperator = $auth->createRole('PrintOperator');
		$PrintOperator->description = 'Print Operator';
		$auth->add($PrintOperator);
		$auth->addChild($PrintOperator, $Search);
		$auth->addChild($PrintOperator, $View);
		$auth->addChild($PrintOperator, $Print);
		$auth->addChild($PrintOperator, $QControl);
		$auth->addChild($PrintOperator, $Mail);

		$OperationsManager = $auth->createRole('OperationsManager');
		$OperationsManager->description = 'Operations Manager';
		$auth->add($OperationsManager);
		$auth->addChild($OperationsManager, $Search);
		$auth->addChild($OperationsManager, $View);
		$auth->addChild($OperationsManager, $Print);
		$auth->addChild($OperationsManager, $QControl);
		$auth->addChild($OperationsManager, $Mail);
		$auth->addChild($OperationsManager, $ViewUpdates);
		$auth->addChild($OperationsManager, $StatusUpdates);
		$auth->addChild($OperationsManager, $DashboardReports);
		$auth->addChild($OperationsManager, $SummaryReports);
		$auth->addChild($OperationsManager, $OperationalReports);

		$AccountsReconciliation = $auth->createRole('AccountsReconciliation');
		$AccountsReconciliation->description = 'Accounts/Reconciliation';
		$auth->add($AccountsReconciliation);
		$auth->addChild($AccountsReconciliation, $DashboardReports);
		$auth->addChild($AccountsReconciliation, $SummaryReports);
		$auth->addChild($AccountsReconciliation, $FinancialReports);

		$SystemAdministrator = $auth->createRole('SystemAdministrator');
		$SystemAdministrator->description = 'System Administrator';
		$auth->add($SystemAdministrator);
		$auth->addChild($SystemAdministrator, $UsersMgmt);
		$auth->addChild($SystemAdministrator, $SystemConfiguration);

		// Root role
		$RootSuperuser = $auth->createRole('RootSuperuser');
		$RootSuperuser->description = 'Root/Superuser';
		$auth->add($RootSuperuser);
		$auth->addChild($RootSuperuser, $VideoAnalyst);
		$auth->addChild($RootSuperuser, $VideoAnalystSupervisor);
		$auth->addChild($RootSuperuser, $PoliceOfficer);
		$auth->addChild($RootSuperuser, $PoliceOfficerSupervisor);
		$auth->addChild($RootSuperuser, $PrintOperator);
		$auth->addChild($RootSuperuser, $OperationsManager);
		$auth->addChild($RootSuperuser, $AccountsReconciliation);
		$auth->addChild($RootSuperuser, $SystemAdministrator);
	}
}
