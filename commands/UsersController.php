<?php
/**
 * Users CLI CRUD
 */

namespace app\commands;

use app\enums\YesNo;
use Yii;
use yii\console\Controller;
use app\modules\auth\components\Auth;
use app\models\User;

/**
 * @author Andrey Prih <prihmail@gmail.com>
 */
class UsersController extends Controller
{
	public function actionAdd($role_name, $user_email, $user_password)
	{
//		$passHash = Yii::$app->rbacUser->generatePasswordHash($user_password);
//		var_dump($user_password);
//		var_dump($passHash);
//		die;
//		string(7) "v_super"
//		string(40) "1c391d7ea3b52d46c0f8f6f953214a798c22165f"

		Yii::$app->rbacUser->createUser([
			'is_active' => YesNo::YES,
			'email' => $user_email,
			'password' => Yii::$app->rbacUser->generatePasswordHash($user_password),
		], $role_name);
	}
}
