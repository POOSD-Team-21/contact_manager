<?php

	$inData = getRequestInfo();
	
	$intnum = $inData['id'];

	
	$searchResults = "";
	$searchCount = 0;
	
	$host = $_ENV['DB_HOST'];
	$database = $_ENV['DB_DATABASE'];
	$user = $_ENV['DB_USERNAME'];
	$password = $_ENV['DB_PASSWORD'];

	$conn = new mysqli($host, $user, $password, $database);

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$query = "DELETE FROM PETS WHERE INTNUM = ?";

		$stmt = $conn->prepare($query);

		$stmt->bind_param('i',$intnum);
		$stmt->execute();
	
		$stmt->close();
		$conn->close();
		
	}
		

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo($firstName, $lastName, $id)
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson($retValue);
	}
?>
