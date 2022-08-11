<?php 

// getDataJson
$apiAlbums = file_get_contents("http://192.168.2.99:8008/albums.json");
$dataAlbums = json_decode($apiAlbums, TRUE);

$apiTodos = file_get_contents("http://192.168.2.99:8008/todos.json");
$dataTodos = json_decode($apiTodos, TRUE);

$apiPosts = file_get_contents("http://192.168.2.99:8008/posts.json");
$dataPosts = json_decode($apiPosts, TRUE);

$apiUsers = file_get_contents("http://192.168.2.99:8008/users.json");
$dataUsers = json_decode($apiUsers, TRUE);

$apiPhotos = file_get_contents("http://192.168.2.99:8008/photos.json");
$dataPhotos = json_decode($apiPhotos, TRUE);


$users = [];
foreach ($dataUsers as $apiUser) {
	// var_dump($apiUser);exit;
	$long = $apiUser['address']['geo']['lng'];
	$lat = $apiUser['address']['geo']['lat'];
	$url = "http://api.geonames.org/countryCodeJSON?formatted=true&lat={$lat}&lng={$long}&username=Plausible0649&style=full";
	$country = file_get_contents($url);
	$dataCountry = json_decode($country, TRUE);
	// var_dump($country);exit;

	$users[$apiUser['id']] = [
		'userId' => $apiUser['id'],
		'name' => $apiUser['name'],
		'country' => $dataCountry['countryName'],
		'numberOfAlbums' => 0,
		'numberOfPosts' => 0,
		'numberOfTodos' => 0,
		'numberOfAlbums' => 0,
		'numberOfPhotos' => 0,
		'participantName' => 'Renny Listyaningsih',
	];
}

foreach ($dataAlbums as $apiAlbum) {
	if (isset($users[$apiAlbum['userId']]['numberOfAlbums'])) {
		$users[$apiAlbum['userId']]['numberOfAlbums'] += 1;
	}
}

foreach ($dataPosts as $apiPosts) {
	if (isset($users[$apiPosts['userId']]['numberOfPosts'])) {
		$users[$apiPosts['userId']]['numberOfPosts'] += 1;
	}
}

foreach ($dataTodos as $apiTodos) {
	if (isset($users[$apiTodos['userId']]['numberOfTodos'])) {
		$users[$apiTodos['userId']]['numberOfTodos'] += 1;
	}
}


$result = [];
foreach ($users as $user) {
	$result[] = $user;
}

$output = [
	"message" => true,
	"data" => $result,
];

$output = json_encode($output);
echo($output);

?>