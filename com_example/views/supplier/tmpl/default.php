<?php
//+_Поречная_***
defined('_JEXEC') or die('Restricted access');

// Подключение библиотеки jQuery
JHtml::_('jquery.framework');

// Подключение библиотек для отрисовки гистограммы
$document = JFactory::getDocument();
$document->addScript('media/***/js/highcharts.js');
$document->addScript('media/***/js/highcharts-exporting.js');

//Вывод частичных шаблонов
echo $this->setLayout('requests');
?>