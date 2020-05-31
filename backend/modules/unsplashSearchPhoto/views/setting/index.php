<?php

use common\models\SocialNetworkAccount;
use common\models\UnsplashSearchPhotoSetting;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\unsplashSearchPhoto\models\search\UnsplashSearchPhotoSettingSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$statusList = [
    1 => Yii::t('backend', 'On'),
    0 => Yii::t('backend', 'Off'),
];

$this->title = Yii::t('backend', 'Unsplash Search Photo Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-setting-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
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
                    'name',
                    'search',
                    'per_page',
                    // 'orientation',
                    // 'collections',
                    [
                        'attribute' => 'is_active',
                        'filter' => $statusList,
                        'value' => function (UnsplashSearchPhotoSetting $data) use ($statusList) {
                            return $statusList[$data->is_active];
                        },
                    ],
                    [
                        'attribute' => 'is_finished',
                        'filter' => $statusList,
                        'value' => function (UnsplashSearchPhotoSetting $data) use ($statusList) {
                            return $statusList[$data->is_finished];
                        },
                    ],
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{view} {update}',
                    ],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
