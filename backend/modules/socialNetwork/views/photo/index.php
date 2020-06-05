<?php

use common\models\SocialNetworkAccount;
use common\models\SocialNetworkPhoto;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\socialNetwork\models\search\SocialNetworkPhotoSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$boolList = [
    0 => Yii::t('backend', 'No'),
    1 => Yii::t('backend', 'Yes'),
];

$this->title = Yii::t('backend', 'Social Network Photos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-photo-index">
    <div class="card">
        <div class="card-header"></div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'social_network_account_id',
                        'value' => 'socialNetworkAccount.name',
                        'filter' => SocialNetworkAccount::find()
                            ->select(['name', 'id'])
                            ->orderBy('name')
                            ->indexBy('id')
                            ->column()
                        ,
                    ],
                    'filename',
                    'file_caption',
                    // 'hash_tags',
                    [
                        'attribute' => 'is_posted',
                        'format' => 'raw',
                        'value' => function (SocialNetworkPhoto $photo) use ($boolList) {
                            if ($photo->posted_at === null) {
                                return '';
                            }
                            return Html::tag('i', '', [
                                'class' => 'fa fa-fw fa-check',
                                'style' => 'color: green',
                            ]);
                        },
                        'filter' => [
                            1 => Yii::t('backend', 'Yes'),
                        ],
                    ],
                    [
                        'attribute' => 'is_skipped',
                        'filter' => $boolList,
                        'format' => 'raw',
                        'value' => function (SocialNetworkPhoto $photo) use ($boolList) {
                            if ($photo->is_skipped === null) {
                                return '';
                            }
                            return Html::tag('i', '', [
                                'class' => 'fa fa-fw fa-' . ($photo->is_skipped ? 'check' : 'times'),
                                'style' => 'color: ' . ($photo->is_skipped ? 'green' : 'red'),
                            ]);
                        },
                    ],
                    // 'created_at',
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{view} {update}',
                    ],
                ],
            ]) ?>
    
        </div>
        <div class="card-footer">
            <?= getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
