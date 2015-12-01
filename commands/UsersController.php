<?php
/**
 * Users CLI CRUD
 */

namespace app\commands;

use yii\console\Controller;

/**
 * @author Andrey Prih <prihmail@gmail.com>
 */
class UsersController extends Controller
{
	public function actionIndex($message = 'hello world')
	{
		echo $message . "\n";
	}
}
