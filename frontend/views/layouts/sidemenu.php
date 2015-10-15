<?php
use kartik\helpers\Html;
use orcsis\widgets\NavX;
use orcsis\admin\components\MenuHelper;
?>
<aside class="left-side sidebar-offcanvas collapse-left">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img
				src="<?= Yii::$app->user->isGuest ? Yii::$app->params['assetUrl'] . 'images/noavatar_man.png':
				Yii::$app->user->identity->usu_type ?
				'data:'.Yii::$app->user->identity->usu_type.';base64,'.base64_encode(Yii::$app->user->identity->usu_foto) :
				Yii::$app->params['assetUrl'] . 'images/noavatar_man.png' ?>"
				class="img-circle" alt="User Image" />
			</div>
			<div class="pull-left info">
				<p><?= Yii::t("app","Hello") . ", " . Html::encode(Yii::$app->user->isGuest?"" : explode(" ",Yii::$app->user->identity->usu_nombre)[0]) ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<?php
		echo NavX::widget ( [ 
			'options' => [ 
			'class' => 'sidebar-menu' 
			],
			'items' => MenuHelper::getAssignedMenu ( Yii::$app->user->id, 2, '\orcsis\helpers\Menu::menuCallBack', true ),
			'encodeLabels' => false
			]);
			?>
		</section>
		<?php echo \kartik\widgets\Alert::widget(['type'=> \kartik\widgets\Alert::TYPE_INFO, 'body'=>Yii::$app->orcsis->getEmpVar('DIRFISCAL')]); ?>
		<?php //$confemp = new \common\models\empresa\Confemp();
			//echo $confemp->RIF;
		//echo \orcsis\angularui\bootstrap\BootstrapExample::widget() ?>
	</aside>