<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once 'NuSOAP/nusoap.php';
//require_once("NuSOAP/lib/nusoap.php");

class NuSoap_lib
{
	function Nusoap_lib()
	{
		require_once('NuSOAP/lib/nusoap.php');
	}

   	function soaprequest($api_url, $api_username, $api_password, $service, $params)
	{
	    if ($api_url != '' && $service != '' && count($params) > 0)
	    {
	        $wsdl = $api_url."?wsdl";
	        $client = new nusoap_client($wsdl, 'wsdl');
	        $client->setCredentials($api_username,$api_password);
	        $error = $client->getError();
	        if ($error)
	        {
	            echo "\nSOAP Error\n".$error."\n";
	            return false;
	        }
	        else
	        {
	            $result = $client->call($service, $params);
	            if ($client->fault)
	            {
	                print_r($result);
	                return false;
	            }
	            else
	            {
	                $result_arr = json_decode($result, true);
	                $return_array = $result_arr['result'];
	                return $return_array;
	            }
	        }
	    }
	}
}
?>