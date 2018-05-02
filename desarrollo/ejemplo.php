<?PHP  
include_once("baachart2.php");
$mygraph = new baaChart(600);
$mygraph->setTitle('Regional Sales','Jan - Jun 2002');
$mygraph->addDataSeries('P',PIE_CHART_PCENT + PIE_LEGEND_VALUE,"25,30,35,40,30,35","South");
$mygraph->addDataSeries('P',PIE_CHART_PCENT + PIE_LEGEND_VALUE,"65,70,80,90,75,48","North");
$mygraph->addDataSeries('P',PIE_CHART_PCENT + PIE_LEGEND_VALUE,"12,18,25,20,22,30","West");
$mygraph->addDataSeries('P',PIE_CHART_PCENT + PIE_LEGEND_VALUE,"50,60,75,80,60,75","East");
$mygraph->addDataSeries('P',PIE_CHART_PCENT + PIE_LEGEND_VALUE,"30,45,50,55,52,60","Europe");
$mygraph->drawGraph();
?>

?>