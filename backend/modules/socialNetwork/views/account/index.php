<?php

use common\models\SocialNetworkAccount;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\socialNetwork\models\search\SocialNetworkAccountSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$statusList = [
    1 => Yii::t('backend', 'On'),
    0 => Yii::t('backend', 'Off'),
];

$this->title = Yii::t('backend', 'Social Network Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-account-index">
    <div class="card">
        <div class="card-header">
            <?= Html::a(Yii::t('backend', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

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
                    'name',
                    [
                        'attribute' => 'type',
                        'filter' => SocialNetworkAccount::TYPE_LIST,
                    ],
                    'login',
                    'count_published',
                    'count_skipped',
                    [
                        'attribute' => 'is_active',
                        'filter' => $statusList,
                        'value' => function (SocialNetworkAccount $data) use ($statusList) {
                            return $statusList[$data->is_active];
                        },
                    ],
                    // 'comment:ntext',
                    // 'password',
                    // 'extra',
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
