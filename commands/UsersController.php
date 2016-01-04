<?php
/**
 * Users CLI CRUD
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\modules\auth\components\Auth;
use app\models\base\User;

/**
 * @author Andrey Prih <prihmail@gmail.com>
 */
class UsersController extends Controller
{
	public function actionAdd($role_name, $user_email, $user_password)
	{
		$auth = Yii::$app->authManager;

		$role = $auth->getRole($role_name);
		if(!$role){
			exit("Error: role '$role_name' - not found!\n");
		}

		$user = new User;

		$user->is_active = 1;
		$user->email = $user_email;
		$user->password = Auth::generatePasswordHash($user_password);
		$user->created_at = time();

		if(!$user->validate()){
			exit("Validate error!\n");
		}

		$user->save();
		$auth->assign($role, $user->id);
	}
}
