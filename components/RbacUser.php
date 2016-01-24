<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 26.11.15
 * Time: 20:03
 */

namespace app\components;

use app\models\User;
use Yii;
use yii\base\InvalidConfigException;
use \app\models\User as UserModel;
use \yii\base\Exception;
use app\enums\Role;
use app\enums\CaseStatus as Status;

class RbacUser extends \app\modules\auth\components\Auth
{

    /**
     * Complete user creation method.
     * Includes password generation, role assign (via model's behavior) and email message sending.
     * @param array $validAttributes
     * @throws Exception
     * @return bool
     * @author Alex Makhorin
     */
    public function createUser($validAttributes)
    {
        $model = new UserModel(['scenario' => UserModel::SCENARIO_REGISTER]);
        $model->attributes = $validAttributes;
        $password = $this->generateNewPassword();
        $model->password = $password;
        $model->activation_hash = Yii::$app->security->generateRandomString();

        if (!$model->save(false)) {
            throw new Exception(Yii::t('app', 'DB error. User was not created.'));
        }

        $activationUrl = \yii\helpers\Url::to([
            '/auth/default/activation',
            self::HASH_PARAM_NAME => $model->activation_hash
        ], true);

        $isSent = Yii::$app->mailer
            ->compose('user_registeredInTheSystem', [
                'login'         => $model->email,
                'password'      => $password,
                'activationUrl' => $activationUrl,
            ])
            ->setTo($model->email)
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['adminFrom']])
            ->setSubject(Yii::t('app', 'TIMS - Registration'))
            ->send();

        if (!$isSent) {
            throw new Exception(Yii::t('app', 'Email sending error occurred'));
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getAvailableStatuses()
    {
        switch (true) {
            case User::hasRole(Role::ROLE_VIDEO_ANALYST):
                return [Status::INCOMPLETE, Status::COMPLETE, Status::FULL_COMPLETE];
            case User::hasRole(Role::ROLE_VIDEO_ANALYST_SUPERVISOR):
                return [Status::COMPLETE, Status::FULL_COMPLETE];
            default:
                return [];
        }
    }

}