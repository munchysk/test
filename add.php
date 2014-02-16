<?php 
if(isset($_POST['submit']))
{
	$address = $_POST['address'];
	$address = str_replace(" ", "+", $address);

	// $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&components=country:MX");
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
	$json = json_decode($json,true);

	echo "<pre>";
	var_dump($json);
	echo "</pre>";
	
	$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

	echo "lat : " . $lat  . "<br>";
	echo "long : " . $long . "<br>";
	mysql_query("insert into `restura");
}

?>
<style>
input[type="text"] {
width: 450px;
}
</style>
<form  action="" method="POST" >
	Name   : <input name="name" type="text" value="" /> <br />
	<!--Email  : <input name="email" type="text" value="" /> <br /> -->
	Adress : <input name="address" type="text" value="300 BOYLSTON AVE E SEATTLE WA 98102 USA"> <br />
    <input type="submit" name="submit" value="save"/>
</form> 

