<?php
//+_Поречная_219
defined('_JEXEC') or die;

// Устанавливаем обработку ошибок в режим использования Exception.
JError::$legacy = false;
// Подключаем логирование.
JLog::addLogger(
    array('text_file' => 'com_example.php'),
    JLog::ALL,
    array('com_example')
);
//sessions
jimport( 'joomla.session.session' );

//load classes
JLoader::registerPrefix('Ext', JPATH_COMPONENT);

Jloader::register('ExtHelper', JPATH_COMPONENT . '/helpers/example.php');

//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
if($controller = $app->input->get('controller','default')) {
    require_once (JPATH_COMPONENT.'/controllers/'.$controller.'.php');
}
 
// Create the controller
$classname = 'ExtControllers'.$controller;
$controller = new $classname();
 
// Perform the Request task
$controller->execute();