<?php

namespace OC\LouvreBundle\Api;

class Stripe
{
	private $api_key;
	
	public function __construct($api_key)
	{
		$this->api_key = $api_key;
	}
	/*
	* Cette methode renvoi un objet de type stdClass
	*/
	public function api($pathURL, array $data) {
		$ch = curl_init();		//initialisation de curl

		//Configuration de curl
		curl_setopt_array($ch, [
			CURLOPT_URL 			=> "https://api.stripe.com/v1/$pathURL",
			CURLOPT_RETURNTRANSFER 	=> true,		// pour ne pas afficher les informations
			CURLOPT_USERPWD 		=> $this->api_key,
			CURLOPT_HTTPAUTH 		=>  CURLAUTH_BASIC,
			CURLOPT_POSTFIELDS 		=> http_build_query($data)
		]);

		// On appele l'API
		$response = json_decode(curl_exec($ch));

		// arreter curl
		curl_close($ch);

		//Renvoyer une exception si l'objet $response à une propriete error
		if (property_exists($response, 'error')) {
			throw new Exception($response->error->message);
		}

		return $response;
	}
}
