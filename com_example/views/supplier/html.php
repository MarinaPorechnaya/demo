<?php
// +_Поречная_***
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');
/**
 * HTML представление.
 */
class ExtViewsSupplierHtml extends JViewHtml
{
	// Формат даты
	protected $format = FALSE;
	// Дата начала периода
	protected $date_start = FALSE;
	// Дата конца периода
	protected $date_finish = FALSE;
	
	function render()
    {
	$this->format = "d-m-Y";
	$this->date_start = date($this->format, mktime(0, 0, 0, date("m"), date("d")-14,   date("Y")));
	$this->date_finish = date($this->format, mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
	
        return parent::render();
    }
}
