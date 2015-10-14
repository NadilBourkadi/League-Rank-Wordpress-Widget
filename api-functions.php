<?php

// uses summoner name on /summoner/by-name/ endpoint and returns the result
function summoner_name($summoner, $server) {

global $riot_api_key;
$summoner_encoded = rawurlencode($summoner);
$summoner_lower = strtolower($summoner_enc);
$curl = curl_init('https://' . $server . '.api.pvp.net/api/lol/' . $server . '/v1.4/summoner/by-name/' . $summoner . '?api_key=' . $riot_api_key);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
return $result;
}

// converts summoner name so we can address the individual array we want to pull an ID from
function summoner_info_array_name($summoner){
	$summoner_lower = mb_strtolower($summoner, 'UTF-8');
	$summoner_nospaces = str_replace(' ', '', $summoner_lower);
	return $summoner_nospaces;
}

// makes api request using summoner_name function, addresses json_decod(ed) array using 
// result of summoner_info_array_name, and returns associated summoner ID 
function summoner_id_from_name($summoner, $server){

$summoner_info = summoner_name($summoner, $server);
$summoner_info_array = json_decode($summoner_info, true);
$summoner_info_array_name = summoner_info_array_name($summoner);
$summoner_id = $summoner_info_array[$summoner_info_array_name]['id'];
return $summoner_id;
}

// uses ID to make a request o the /league/by-summoner/ endpoint and returns the
// json_decode(ed) result
function summoner_by_id_array($summoner_id, $server){

global $riot_api_key;
$curl = curl_init('https://' . $server . '.api.pvp.net/api/lol/' . $server . '/v2.5/league/by-summoner/' . $summoner_id . '/entry?api_key=' . $riot_api_key);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
$decoded_result = json_decode($result, true);
return $decoded_result;

}

?>