<?php
$mysql = new SaeMysql();
 
$sql = "CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32)  NOT NULL,
  `source` int(11) NOT NULL,
  `password` varchar(32),
  PRIMARY KEY  (`id`)
);";

$data = $mysql->getData( $sql );
$mysql->runSql( $sql );
if( $mysql->errno() != 0 )
{
    die( "Error:" . $mysql->errmsg() );
}
 
$mysql->closeDb();
?>