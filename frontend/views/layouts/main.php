<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use kartik\nav\NavX;
use orcsis\admin\components\MenuHelper;
use kartik\icons\Icon;
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
	<div class="wrapper row-offcanvas row-offcanvas-left">
		
		<?= Yii::$app->user->isGuest? '' : $this->render('sidemenu')?>
		<aside class="right-side strech">
		<?= Yii::$app->user->isGuest? '' : $this->render('contentHeader')?>
		<section class="content">
				<div class="container">
        		<?= Alert::widget()?>
        		<?= $content?>
        	</div>
			</section>
		</aside>
	</div>
	<footer id="footer" class="footer"
		style="bottom: 0; left: 0; margin: 0; right: 0; position: fixed; z-index: 1000000; height: 40px; padding-top: 10px;">
		<div class="container">
			<p class="pull-left"><?= Yii::$app->params['moduleActive']['name'] ?></p>
			<p class="pull-right">&copy; My Company <?= date('Y') ?></p>
		</div>
	</footer>

    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
