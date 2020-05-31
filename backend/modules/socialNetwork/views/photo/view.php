<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkPhoto $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Network Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-photo-view">
    <div class="card">
        <div class="card-header">
            <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'social_network_account_id',
                    'filename',
                    'file_caption',
                    'is_skipped',
                    'skip_message',
                    'posted_at',
                    'created_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
