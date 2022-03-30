<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$DB = new mysqli('localhost','yuma','AtQLqxFK*l.HRoSZ','yuma');
$existing = [];
if (($handle = fopen("mbs.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $old = $DB->query("SELECT id FROM api_mbs_products_list WHERE Prodotto='$data[0]'");
	if ($old->num_rows > 0){
		
		//$old_id = $old->fetch_object()->id;
		//array_push($existing, $old_id);
		//$DB->query("UPDATE api_mbs_products_list_temp SET Costo = '$data[5]', Scontrino = '$data[8]', CodiceIVA = '$data[9]', Contabilita = '$data[10]' WHERE id='$old_id'");
		//echo "<br>$old_id updated";
		
	} else {
		$DB->query("INSERT INTO `api_mbs_products_list`(`Prodotto`, `Operatore`, `Tipo`, `SottoTipo`, `Descrizione`, `PrezzoUtente`, `image`, `Costo`, `Scontrino`, `CodiceIVA`, `Contabilita`) VALUES ('$data[0]','$data[1]','$data[3]','$data[4]','".$DB->escape_string($data[7])."','$data[6]','$data[2]','$data[5]','".$DB->escape_string($data[8])."','$data[9]','$data[10]')");
		array_push($existing, $DB->insert_id);
		if ($DB->error){ echo "<br>".$DB->error; }
		echo "<br>".$DB->insert_id." insert";
	}
  }
  fclose($handle);
}

//$DB->query("DELETE FROM api_mbs_products_list_temp WHERE id NOT IN ('".implode("','",$existing)."')");
//echo "<br>".$DB->affected_rows." deleted";

echo '<br>done';