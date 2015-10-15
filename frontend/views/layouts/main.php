<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\widgets\Growl;
use kartik\nav\NavX;
use orcsis\admin\components\MenuHelper;
use kartik\icons\Icon;
use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use common\models\Osempresas;

Icon::map ( $this );

/**
 *
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register ( $this );
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
	<?= Html::csrfMetaTags()?>
</head>
<body class="skin-blue wysihtml5-supported pace-done">
    <?php $this->beginBody()?>
    <header class="header">
        <?php
								NavBar::begin ( [ 
								'brandLabel' => 'Orcsis',
								'brandUrl' => Yii::$app->homeUrl,
								'options' => [ 
								'class' => 'navbar navbar-default navbar-static-top',
								'role' => 'navigation' 
								] 
								] );
								?>
       <?php
							$menuItems = MenuHelper::getAssignedMenu ( Yii::$app->user->id, 1, '\orcsis\helpers\Menu::menuCallBack', true );
							echo NavX::widget ( [ 
							'options' => [ 
							'class' => 'navbar-nav' 
							],
							'items' => $menuItems,
							'activateParents' => false,
							'encodeLabels' => false 
							] );
							?>
			<?= Yii::$app->user->isGuest? '' : $this->render('user')?>
		<?php
		NavBar::end ();
		?>
    </header>
    <?php
    if(Yii::$app->session->hasFlash('SelEmpresa')){
			Modal::begin([
    			'options'=>['id'=>'selempresa-modal'],
    			'header' => '<h4 style="margin:0; padding:0">' . Yii::t('app','Select Company') . '</h4>',
    			'closeButton' => false,
    			'toggleButton' =>false,
    			'clientOptions'=>['show' => true, 'keyboard' => false, 'backdrop' => 'static'],
			]);
			$form = ActiveForm::begin([
				'id' => 'SelEmpresa-form',
				'type' => ActiveForm::TYPE_VERTICAL,
				'action' => ['site/sel-empresa']
			]);
			echo Select2::widget([
	    		'name' => 'usu_empresa',
    			'data' => Osempresas::getEmpresas(),
    			'options' => ['placeholder' => Yii::t('app','Select Company') . ' ...'],
    			'pluginOptions' => [
	        		'allowClear' => true
    			],
			]);
			echo '<div class="modal-footer">';
			echo Html::submitButton(Yii::t('app','Accept'), ['class' => 'btn btn-primary']);
			echo '</div>';
			ActiveForm::end();
			Modal::end();
		}
	?>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		
		<?= Yii::$app->user->isGuest? '' : $this->render('sidemenu')?>
		<aside class="right-side strech">
		<?= Yii::$app->user->isGuest? '' : $this->render('contentHeader')?>
		<section class="content">
				<div class="container">
        		<?= Growl::widget()?>
        		<?= $content?>
        	</div>
			</section>
		</aside>
	</div>
	<footer id="footer" class="footer"
		style="bottom: 0; left: 0; margin: 0; right: 0; position: fixed; z-index: 1030; height: 40px; padding-top: 10px;">
		<div class="container">
			<p class="pull-left"><?= date('d-m-Y') . " | " .Yii::$app->params['moduleActive']['name'] ?></p>
			<p class="pull-right">&copy; <?= !Yii::$app->user->isGuest && isset(Yii::$app->user->identity->osempresa->emp_nombre) ? Yii::$app->user->identity->osempresa->emp_nombre : '' ?></p>
		</div>
	</footer>

    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
