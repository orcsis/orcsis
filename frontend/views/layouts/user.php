<?php
use kartik\helpers\Html;

/**
 *
 * @var yii\web\View $this
 */
?>

<div class="navbar-right">
	<ul class="nav navbar-nav">
		<!-- User Account: style can be found in dropdown.less -->
		<li class="dropdown user user-menu"><a href="#"
			class="dropdown-toggle" data-toggle="dropdown"> <i
				class="glyphicon glyphicon-user"></i> <span><?= Html::encode((Yii::$app->user->isGuest?"":Yii::$app->user->identity->usu_nombre)) ?> <i
					class="caret"></i></span>
		</a>
			<ul class="dropdown-menu">
				<!-- User image -->
				<li class="user-header bg-light-blue"><img
					src="<?= Yii::$app->user->isGuest ? Yii::$app->params['assetUrl'] . 'images/noavatar_man.png':
						Yii::$app->user->identity->usu_type ?
						'data:'.Yii::$app->user->identity->usu_type.';base64,'.base64_encode(Yii::$app->user->identity->usu_foto) :
						Yii::$app->params['assetUrl'] . 'images/noavatar_man.png' ?>"
					class="img-circle" alt="User Image" />
					<p>
						<?= Html::encode(Yii::$app->user->isGuest?"":Yii::$app->user->identity->usu_nombre) ?> - Web Developer <small>Member
							since Nov. 2012</small>
					</p></li>
				<!-- Menu Body -->
				<li class="user-body">
					<div class="col-xs-4 text-center">
						<a href="#">Followers</a>
					</div>
					<div class="col-xs-4 text-center">
						<a href="#">Sales</a>
					</div>
					<div class="col-xs-4 text-center">
						<a href="#">Friends</a>
					</div>
				</li>
				<!-- Menu Footer-->
				<li class="user-footer">
					<div class="pull-left">
						<a href="#" class="btn btn-default btn-flat"><?= Yii::t('app','Profile')?></a>
					</div>
					<div class="pull-right">
						<?= Html::a(Yii::t('app','Logout'),['/site/logout'],['class'=>"btn btn-default btn-flat", 'data-method' => 'post'])?>
					</div>
				</li>
			</ul></li>
	</ul>
</div>