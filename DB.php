<?php

try{
	$con = new PDO('mysql:host=localhost;dbname=file_manager', 'root', '');
	$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}catch(PDOException $e){
	echo $e->getMessage();
}

?>