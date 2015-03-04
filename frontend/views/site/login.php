<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \common\models\LoginForm $model
 */
$this->title = Yii::t('app','Login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ingresar</h3>
				</div>
				<div class="panel-body">
					<?php
						$form = ActiveForm::begin();
						echo Form::widget([
							'model' => $model,
							'form' => $form,
							'attributes' => $model->formAttributes
						]);
						echo ' ' . Html::submitButton(Yii::t('app','Login'), ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']);
						ActiveForm::end();
					?>
				</div>
			</div>
		</div>
	</div>
</div>