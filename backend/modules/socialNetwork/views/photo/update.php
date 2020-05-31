<?php

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkPhoto $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Social Network Photo',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Network Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="social-network-photo-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
