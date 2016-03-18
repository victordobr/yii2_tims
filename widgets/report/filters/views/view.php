<?php

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use app\enums\report\ReportGroup;
use app\widgets\report\filters\Filters;

?>

<div class="row" xmlns="http://www.w3.org/1999/html">

    <div class="panel panel-default panel-record-filter">
        <div class="panel-heading"><?= Yii::t('app', 'Filter by') ?></div>

        <div id="record-reports-filter" class="panel-body">

            <?php $form = ActiveForm::begin([
                'id' => 'form-record-reports-filter',
                'type' => ActiveForm::TYPE_VERTICAL,
                'enableClientScript' => false,
                'method' => 'GET',
                'options' => ['data-pjax' => true]
            ]); ?>

                <?php if ($mode[Filters::FILTER_DATE_RANGE] == true) :?>
                    <div class="row">
                        <?= $this->render('form/date', ['model' => $model, 'form' => $form]); ?>
                    </div>
                <?php endif; ?>

                <?php if ($mode[Filters::FILTER_BUS_NUMBER] == true) :?>
                    <div class="row">
                        <?= $this->render('form/bus', ['model' => $model, 'form' => $form]); ?>
                    </div>
                <?php endif; ?>

                <?php if ($mode[Filters::FILTER_AUTHOR] == true) :?>
                    <div class="row">
                        <?= $this->render('form/author', ['model' => $model, 'form' => $form]); ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="form-group text-right">
                        <!--             //Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-default btn-submit']) ?>-->
                        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-sm btn-default btn-reset']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>

        </div>

        <div class="panel-footer">
            <div class="row">
                <?= Html::a(Yii::t('app', 'Print Report'), '#' , ['class' => 'btn btn-default', 'role' => 'button']) ?>
            </div>
        </div>

    </div>

</div>