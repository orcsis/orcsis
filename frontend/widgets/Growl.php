<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * - \Yii::$app->getSession()->setFlash('error', 'This is the message');
 * - \Yii::$app->getSession()->setFlash('success', 'This is the message');
 * - \Yii::$app->getSession()->setFlash('info', 'This is the message');
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Growl extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => \kartik\widgets\Growl::TYPE_DANGER,
        'danger'  => \kartik\widgets\Growl::TYPE_DANGER,
        'success' => \kartik\widgets\Growl::TYPE_SUCCESS,
        'info'    => \kartik\widgets\Growl::TYPE_INFO,
        'warning' => \kartik\widgets\Growl::TYPE_WARNING,
        'primary' => \kartik\widgets\Growl::TYPE_GROWL,
        'growl'   => \kartik\widgets\Growl::TYPE_GROWL
    ];

    /**
     * @var array the alert icons.
     *
     */
    public $alertIcons = [
        'error'   => 'glyphicon glyphicon-remove-sign',
        'danger'  => 'glyphicon glyphicon-remove-sign',
        'success' => 'glyphicon glyphicon-ok-sign',
        'info'    => 'glyphicon glyphicon-info-sign',
        'warning' => 'glyphicon glyphicon-exclamation-sign',
        'primary' => 'glyphicon glyphicon-exclamation-sign',
        'growl'   => 'glyphicon glyphicons-message-flag'
    ];

    /**
     * @var array the alert Title.
     *
     */
    public $alertTitle = [
        'error'   => 'Error',
        'danger'  => 'Warning',
        'success' => 'Success',
        'info'    => 'Info',
        'warning' => 'Warning',
        'primary' => 'Info',
        'growl'   => 'Info'
    ];

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public function init()
    {
        parent::init();

        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $message) {
            if (isset($this->alertTypes[$type])) {
                /* initialize css class for each alert box */
                //$this->options['class'] = $this->alertTypes[$type] . $appendCss;

                /* assign unique id to each alert box */
                $this->options['id'] = $this->getId() . '-' . $type;

                echo \kartik\widgets\Growl::widget([
                    'type' => $this->alertTypes[$type],
                    'icon' => $this->alertIcons[$type],
                    'title' => \Yii::t('app',$this->alertTitle[$type]),
                    'showSeparator' => true,
                    'body' => $message,
                    'closeButton' => $this->closeButton,
                    'options' => $this->options,
                    //'delay' => isset(\Yii::$app->params['AlertDelay']) ? \Yii::$app->params['AlertDelay'] : false,
                    'pluginOptions' => [
                        'delay' => isset(\Yii::$app->params['AlertDelay']) ? \Yii::$app->params['AlertDelay'] : false,
                        'placement' => [
                            'from' => 'bottom',
                            'align'=> 'right'
                        ],
                    ],
                    'delay' => false,
                ]);

                $session->removeFlash($type);
            }
        }
    }
}
