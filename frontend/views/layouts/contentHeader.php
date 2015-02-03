<?php
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\widgets\Breadcrumbs;
use kartik\nav\NavX;
use orcsis\admin\components\MenuHelper;

$menuItems = [
                ['label' => Icon::show('navicon', ['class' => 'fa-2x']), 'url' => ['#'], 'linkOptions' => ['class' => 'navbar-btn sidebar-toggle','data-toggle' => 'offcanvas' ]],
            ];
$menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->usu_nombre . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post', 'class' => 'btn btn-app' ]
                ];
?>
<section class="content-header">
	<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas"
		role="button">
		<?= Icon::show('navicon', ['class' => 'fa-2x'])?>
	</a>
	<a class="btn btn-app">
    	<i class="fa fa-save"></i>
    	Save
    </a>
    <a class="btn btn-app">
    	<i class="fa fa-edit"></i> Edit
    </a>
    <!--<?php echo NavX::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $menuItems,
    			'activateParents' => false,
				'encodeLabels' => false 
            ]);?>-->
	<?= Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?> 
</section>