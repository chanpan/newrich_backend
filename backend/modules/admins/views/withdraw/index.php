<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'ถอนเงิน';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <h2><?= Html::encode($this->title) ?> </h2>
    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'id' => 'withdraw-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('app', 'Update'),
                                yii\helpers\Url::to(['withdraw/update?id=' . $model->id]), [
                                    'title' => Yii::t('app', 'Update'),
                                    'class' => 'btn btn-primary btn-sm',
                                    'data-action' => 'update',
                                    'data-pjax' => 0
                                ]);
                        },
//                        'delete' => function ($url, $model) {
//                            return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'Delete'),
//                                yii\helpers\Url::to(['withdraw/delete?id=' . $model->id]), [
//                                    'title' => Yii::t('app', 'Delete'),
//                                    'class' => 'btn btn-danger btn-xs',
//                                    'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
//                                    'data-method' => 'post',
//                                    'data-action' => 'delete',
//                                    'data-pjax' => 0
//                                ]);
//
//
//                        },
                    ]
                ],
                [
                    'attribute'=>'user_id',
                    'value'=>function($model){
                        return \backend\lib\CNUtils::getUserById($model->user_id);
                    },
                    'filter'=>\yii\helpers\ArrayHelper::map(\common\modules\user\models\Profile::find()->asArray()->all(), 'user_id', 'name'),
                ],
                [
                    'format'=>'raw',
                    'contentOptions'=>['class'=>'text-right'],
                    'attribute'=>'amount',
                    'value'=>function($model){
                        return isset($model->amount) ? number_format($model->amount,2):'';
                    }

                ],
                [
                    'format'=>'raw',
//                    'contentOptions'=>['class'=>'text-right'],
                    'attribute'=>'createDate',
                    'value'=>function($model){
                        return isset($model->createDate) ? \backend\lib\CNUtils::getDateDmyHis($model->createDate):'';
                    }
                ],
                [

                    'contentOptions' => ['style'=>'width:130px;text-align: center;'],
                    'attribute'=>'status',
                    'value'=>function($model){
                        $item = \backend\lib\CNUtils::$statusWithdraw;
                        if(!$model->status){
                            return $item['0'];
                        }
                        return $item[$model->status];
                    },
                    'filter'=>\backend\lib\CNUtils::$statusWithdraw,
                ],
                [
                    'attribute'=>'approveBy',
                    'value'=>function($model){
                        return \backend\lib\CNUtils::getUserById($model->approveBy);
                    },
                    'filter'=>\yii\helpers\ArrayHelper::map(\common\modules\user\models\Profile::find()->asArray()->all(), 'user_id', 'name'),
                ],
            ]

        ]); ?>

    </div>
</div>
