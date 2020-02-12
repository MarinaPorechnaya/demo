<?php
//+_Поречная_***
defined('_JEXEC') or die('Restricted access');

$model = new ExtModelsSupplier();
$sRequests = $model->getRequests();
$aRequestsAll = $model->getAllRequests();
?>

<div class="row">
	  <div class="span9">
		    <!--Блок гистограммы "Запоросы пользователей"-->
		    <div id="requests"></div>
	  </div>
	  <div class="span3">
		    <table class="table table-bordered">
			      <tr>
					<td rowspan=2><strong>Итого запросов:</strong></td>
					<td>по собственным подборам</td>
					<td><?=count($aRequestsAll);?></td>
			      </tr>
			      <tr>
					<td>данному поставщику</td>
					<td><?=count($sRequests);?></td>
			      </tr>
			      <tr>
					<td colspan=3>c <?=$this->date_start?> по <?=$this->date_finish?></td>
			      </tr>
		    </table>
	</div>
</div>  
<?php
// Инициализация массива данных
$aItemdates = array();
$aItemDatesAll = array();

// Перебираем данные, фильтруем по датам, форматируем даты
foreach ( $aRequestsAll as $aItemsReqAll ){ 
    $aItemDatesAll[] = date($this->format, strtotime($aItemsReqAll['date']));
}

foreach ( $sRequests as $aItems ){ 
    $aItemdates[] = date($this->format, strtotime($aItems['date']));
}


// Преобразуем массив подборов так чтобы ключами были даты запросов, а
// значениями - количество запросов в этот день
$dates_array = array_count_values($aItemdates);
$aDatesAll = array_count_values($aItemDatesAll);

// Переменная со значением 0
$zero = 0;

$period = strtotime($this->date_finish) - strtotime($this->date_start);
?>

<!--Скрипт формирования гистограммы-->
<script>
    jQuery(function () {
        jQuery('#requests').highcharts({
            chart: {
                type: 'area' // тип гистограммы - колонки
            },
            title: {
                text: 'Количество отправленных запросов '// заголовок гистограммы
            },
            xAxis: {// подгружаем даты запросов в ось x
                 categories: [<?php

                    for($i = 0; $i <= $period; $i += 86400){
                        $d = date($this->format, strtotime($this->date_start) + $i);
                        if($i >= $period){
                            echo ("'$d'");
                        }
                        else{
                            echo ("'$d', ");
                        }
                    }
                    ?>]
            },
	    yAxis: { //параметры оси y
                min: 0,
                title: {
                    text: 'Запросов'
                }
            },
            credits: {
                enabled: false
            },
            series: [{ //формируем столбцы гистограммы
                name: 'Всего',
                data: [<?php
                        for($i = 0; $i <= $period; $i += 86400){
                            $d = date($this->format, strtotime($this->date_start) + $i);
                            if(array_key_exists ("$d" , $aDatesAll)){
                                echo ($aDatesAll["$d"].", ");
                            }
                            else{
                                echo ($zero.", ");
                            }
                        }
                    ?>],
                color: '#006dcc'
            },
	    {  name: 'Данному поставщику',
                data: [<?php
                        for($i = 0; $i <= $period; $i += 86400){
                            $d = date($this->format, strtotime($this->date_start) + $i);
                            if(array_key_exists ("$d" , $dates_array)){
                                echo ($dates_array["$d"].", ");
                            }
                            else{
                                echo ($zero.", ");
                            }
                        }
                    ?>],
                color: '#4ED24E'
            }]
        });
    });
</script>