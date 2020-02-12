<?php
/**
 * @author     Поречная М.В.
 *
 * @description Скрипт реализует упрощенный RFM-анализ покупателей.
 * подготовка: выполнить ALTER TABLE  `sc_customers` ADD  `RFM` VARCHAR( 10 ) NOT NULL
 * допустимо использование псевдокода
 * 
 */

class RFM {

   /**
     * Получает данные из таблиц БД.
     *
     * @return  array .
     */
    public function getData() {
        $sQuery = "SELECT customers.customerID, SUM(orders.order_amount) as sum, COUNT(orders.orderID) as cnt FROM  SC_customers as customers
                    INNER JOIN sc_orders as orders on customers.customerID=orders.customerID
                    WHERE orders.statusID = 5 AND customers.email <> ''
                    GROUP BY customers.customerID";
        return $this->getDataRaw( $sQuery );
    }

    /**
     * Формирует список клиентов с номерами сегментов.
     *
     * @return  array .
     */
    public function setData( $aCustomers )
    {
	$sQuery = "UPDATE SC_customers SET RFM =CASE ";
	$keys=array();
	foreach( $aCustomers as $key => $val ){
	    $sQuery .= "WHEN customerID = '" . $key . "'THEN '" . $val . "'";
	    $keys[]=$key;
	}
	$sQuery .= 'END WHERE `customerID` IN (' . implode( ',' , $keys ) . ')'; 
	return $this->getDataRaw( $sQuery ); 
    }
    
    /**
     * RFM-анализ.
     *
     * @return  void .
     */
    public function processRFM(){
	
	$aData = $this->getData();
	
	//формируем отдельные массивы для суммы и количества
	$aSums = array();
	$aNum = array();
	foreach($aData as $val){
	    $aSums[] = $val['sum'];    
	    $aNum[] = $val['cnt'];
	}
	//определяем интервалы исходя из максимального значения
	$x = intval( max( $aNum )/3 )+ 1;
	$a = array('R1'=>range(0, $x),'R2'=>range($x+1,$x*2),'R3'=>range($x*2+1,$x*3));
	$y = intval( max( $aSums )/3 ) + 1;
	$b = array('M1'=>range(0, $y),'M2'=>range($y+1,$y*2),'M3'=>range($y*2+1,$y*3));
	
	//формируем список клиентов с номерами сегментов.
	$ar = array();
	foreach( $echo as $v ){
	    
	    foreach($a as $k=>$vl){
		if(in_array($v['cnt'],$vl)) $R = $k;
	    }
	    foreach($b as $k=>$vl){
		if(in_array($v['sum'],$vl)) $M = $k;
	    }
	$ar[$v['customerID']] = $R . ":" . $M; 
	}
	
	//записываем изменения в БД
	$this->setData($ar);
    }
  
    /**
     * Подключение к БД, обработка запроса
     *
     */
    public function getDataRaw($sQuery) {
        //здесь операторы обработки запроса $sQuery, зависящие от специфики
    }
}
