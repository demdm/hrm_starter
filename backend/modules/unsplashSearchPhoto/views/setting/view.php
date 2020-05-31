<?php

use common\models\UnsplashSearchPhotoSetting;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoSetting $model
 */

$statusList = [
    1 => Yii::t('backend', 'On'),
    0 => Yii::t('backend', 'Off'),
];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Unsplash Search Photo Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-setting-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'social_network_account_id',
                    'name',
                    'search',
                    'per_page',
                    'orientation',
                    'collections',
                    'comment',
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
                ],
            ]) ?>
        </div>
    </div>
</div>
