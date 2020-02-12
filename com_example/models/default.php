<?php

//+_Поречная_***
defined('_JEXEC') or die('Restricted access');

class ExtModelsDefault extends JModelBase {

    protected $_db = FALSE;
    protected $id_product = FALSE;

    function __construct() {
        $this->_db = JFactory::getDBO();
	
	if( isset( $_REQUEST[ 'id_product' ] ) ){
	    $this->id_product = (int) $_REQUEST[ 'id_product' ];
	}
        parent::__construct();
    }

    /**
     * Получает массив объектов из database query.
     *
     *
     */
    public function getDataRaw($sQuery) {
        $db = JFactory::getDBO();
        $db->setQuery($sQuery);
        $result = $db->loadObjectList();

        if (empty($result)) {
            return array();
            throw new Exception(JText::_('COM_EXAMPLE_ERROR_ELEMENTS_NOT_FOUND'), 404);
        }
        $data_row = $db->loadAssocList();
        return $data_row;
    }

}
