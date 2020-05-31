<?php

use common\models\SocialNetworkAccount;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkAccount $model
 */

$statusList = [
    1 => Yii::t('backend', 'On'),
    0 => Yii::t('backend', 'Off'),
];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Network Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-account-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'comment:ntext',
                    'type',
                    'login',
                    'password',
                    'extra',
                    'count_published',
                    'count_skipped',
                    [
                        'attribute' => 'is_active',
                        'filter' => $statusList,
                        'value' => function (SocialNetworkAccount $data) use ($statusList) {
                            return $statusList[$data->is_active];
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
