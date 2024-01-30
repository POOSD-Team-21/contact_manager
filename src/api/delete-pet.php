<?php

	loadEnv(__DIR__.'/../.env');

	$host = $_ENV['DB_HOST'];
	$database = $_ENV['DB_DATABASE'];
	$user = $_ENV['DB_USERNAME'];
	$dbPassword = $_ENV['DB_PASSWORD'];

	$inData = getRequestInfo();
	
	$intnum = $inData['id'];

	
	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli($host, $user, $dbpassword, $database);

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
	
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception('.env file not found');
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        $_ENV[$key] = $value;
    }
}
?>
