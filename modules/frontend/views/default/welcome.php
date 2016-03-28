<?php
/**
 * @var string $username
 * @var string $last_login 26 February 2016 as 08:17:12 EST.
 */
?>
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel panel-default panel-welcome">
        <div class="panel-heading">
            <h4><?= Yii::t('app', 'Welcome, {username}', ['username' => $username]) ?></h4>
        </div>
        <div class="panel-body">
            <p class="t-sm-gray"><?= Yii::t('app', 'Your last login was on {last}', ['last' => $last_login]) ?></p>
            <p class="t-lg-gray"><?= Yii::t('app', 'Please select an action from the menu above.') ?></p>
        </div>
    </div>
</div>
