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
		Yii::$app->user->createUser([
			'is_active' => YesNo::YES,
			'email' => $user_email,
			'password' => Yii::$app->user->generatePasswordHash($user_password),
		], $role_name);
	}
}
