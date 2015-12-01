<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\admin\models\search\User $searchModel
 * @var int $autoCompleteLimit
 * @var int $modelCode Model code for suggestions
 */

use \yii\helpers\Html;
use \app\models\User;
$this->title = \Yii::t('app', 'Manage Users');
$clearLabel = \Yii::t('app', 'Clear Filters');
?>
<div class="user-index">
    <?php
    yii\widgets\Pjax::begin([
        'id' => 'admin-user-id',
        'timeout' => false,
        'enablePushState' => false,
    ]);
    ?>

    <div class="header-title">
        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>
    </div>

    <p>
        <?= yii\helpers\Html::a( \Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => '0']) ?>
    </p>

    <?= yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'columns' => [
            [
                'label' => '#',
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 100px;']
            ],
            [
                'attribute'       => 'fullName',
                'value'           => 'fullName',
                'filter'          => kartik\typeahead\Typeahead::widget([
                    'model'         => $model,
                    'attribute'     => 'fullName',
                    'value'         => $model->getFullName(),
                    'dataset'       => [
                        [
                            'display' => 'value',
                            'remote'  => [
                                'url'      => \yii\helpers\Url::to(['suggestion', 'code' => $modelCode, 'field' => 'fullName', 'value' => '%value']),
                                'wildcard' => '%25value'
                            ],
                            'limit'   => $autoCompleteLimit,
                        ]
                    ],
                    'pluginOptions' =>
                        [
                            'highlight' => true,
                            'minLength' => 3,
                        ],
                ])
            ],
            [
                'attribute' => 'phone',
                'headerOptions' => ['style' => 'width: 120px;']
            ],
            [
                'attribute' => 'email',
                'format' => 'email',
                'headerOptions' => ['style' => 'width: 250px;']
            ],
            [
                'attribute' => 'logins_count',
                'headerOptions' => ['style' => 'width: 40px;']
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'headerOptions' => ['style' => 'width: 150px;'],
                'filter'          => kartik\daterange\DateRangePicker::widget([
                    'name'          => 'User[created_at]',
                    'value'         => $model->created_at,
                    'pluginOptions' => [
                        'opens' => 'left'
                    ]
                ]),
            ],
            [
                'attribute' => 'last_login_at',
                'format' => 'datetime',
                'headerOptions' => ['style' => 'width: 150px;'],
                'filter'          => kartik\daterange\DateRangePicker::widget([
                    'name'          => 'User[last_login_at]',
                    'value'         => $model->last_login_at,
                    'pluginOptions' => [
                        'opens' => 'left'
                    ]
                ]),
            ],
            [
                'class' => \dosamigos\grid\ToggleColumn::className(),
                'attribute' => 'is_active',
                'onValue' => User::STATUS_ACTIVE,
                'onLabel' => \Yii::t('app','Active'),
                'offLabel' => \Yii::t('app','Not active'),
                'contentOptions' => ['class' => 'text-center'],
                'afterToggle' => 'function(r, data){}',
                'onIcon' => 'glyphicon glyphicon-ok text-success',
                'offIcon' => 'glyphicon glyphicon-remove text-danger',
                'filter' => \app\enums\YesNo::listData(),
                'headerOptions' => ['style' => 'width: 85px;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
//                        if(!\Yii::$app->get('service|user')->haveDeletePermission($model->primaryKey)){
//                            return '';
//                        }

                        $options = [
                            'title' => \Yii::t('yii', 'Delete'),
                            'aria-label' => \Yii::t('yii', 'Delete'),
                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
//                        if(\Yii::$app->user->id == $model->primaryKey){
//                            return '';
//                        }

                        $options = array_merge([
                            'title' => \Yii::t('yii', 'Update'),
                            'aria-label' => \Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                ],
                'headerOptions' => ['style' => 'width: 70px;'],
            ],
        ],
    ]);
    yii\widgets\Pjax::end();
    $this->registerJs(
        '$("document").ready(function(){
        $("#admin-user-id").on("pjax:start", function() {
            $("#admin-user-id").addClass("page-loading");
        });

        $("#admin-user-id").on("pjax:end", function() {
            $("#admin-user-id").removeClass("page-loading");
        });

        $(".active_toggle").click(function(e){
            if($(e.target).hasClass("glyphicon-ok") && !confirm("' .\Yii::t('app', 'USER_DEACTIVATE_PROMPT') .'")){
                e.preventDefault;
                return false;
            }
        });
    });'
    );
    ?>

</div>
