<?php

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkAccount $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Social Network Account',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Network Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-account-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
