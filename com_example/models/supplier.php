<?php
//+_Поречная_***
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class ExtModelsSupplier extends ExtModelsDefault {

    protected $id_supplier = FALSE;
    protected $format = FALSE;
    protected $date_start = FALSE;
    protected $date_finish = FALSE;


    public function __construct( $config = array() )
    {
	$this->id_supplier = (int) $_REQUEST['id_supplier'];
	$this->format = "Y-m-d H:i:s";
	// Дата начала периода по умолчанию
        $this->date_start = date($this->format, mktime(0, 0, 0, date("m"), date("d")-14,   date("Y")));
        // Дата конца периода по умолчанию
        $this->date_finish = date($this->format, mktime(23, 59, 59, date("m"), date("d"),   date("Y")));;

        parent::__construct( $config );
    }

    /**
     * Метод получает все пользовательские запросы.
     *
     * @return  array.
     */
    public function getAllRequests()
    {
        $query = "SELECT * FROM X Where id_supplier='" . $this->id_supplier . "'
		AND (date between '".$this->date_start."' AND '".$this->date_finish."')
		ORDER BY date DESC";

        return $this->getDataRaw($query);
    }
    
    /**
     * Метод получает пользовательские запросы для данного поставщика.
     *
     * @return  array.
     */
    public function getRequests()
    {
        $query = "SELECT log.date, log.code, log.id_product, log.date, log.id_supplier FROM X log
		INNER JOIN Y item ON item.id = log.id_product
		LEFT JOIN Z t_type ON t_type.type = item.type
		Where (log.date between '".$this->date_start."' AND '".$this->date_finish."')
		AND t_type.id_suppliers='" . $this->id_supplier . "'
		ORDER BY log.date DESC";

        return $this->getDataRaw($query);
    } 
    
}