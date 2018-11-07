<?php
session_start();
//Need to use an autoloader to import PHPOnCouch classes
$autoloader = join(DIRECTORY_SEPARATOR,[__DIR__,'vendor','autoload.php']);
require $autoloader;

//import the classes that we need
use PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;

//create a client to access the database
$client = new CouchClient('http://Eoin:gesq4qxq@localhost:5984','vehicles');

error_reporting(E_ERROR);

//Retrieve Document ID using button name and get Document using ID
$doc_id = $_POST["ID"];
try {
    $doc = $client->getDoc($doc_id);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")<br>\n";
}
?>

<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Vehicles table - CouchDB Project">
<meta name="author" content="Eoin McGrath">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/1.0.0/awesome-bootstrap-checkbox.css">
<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>

<title>Vehicles</title>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>


<!-- Form Begins -->
<div class="container">
<br>
    <form id="updateForm" role="form" method="post" action="index.php">
        <!-- assigns name to the id field -->
        <input type="hidden" name="updateID" value="<?php echo $doc_id ?>"/>
        <div class="row">
            <div class="form-group col">
              <label>Make</label>
              <input class="form-control form-control-sm" name="Make" value="<?php echo $doc->make ?>"> 
            </div>

            <div class="form-group col">
              <label>Model</label>
              <input class="form-control form-control-sm" name="Model" value="<?php echo $doc->model ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
              <label>Year</label>
              <input class="form-control form-control-sm" name="Year" value="<?php echo $doc->year ?>">
            </div>
      
            <div class="form-group col">
              <label>Engine Size</label>
              <input class="form-control form-control-sm" name="Enginesize" value="<?php echo $doc->enginesize ?>">
            </div>
        </div>
        <div class="row">

            <div class="form-group col">
              <label>Fuel Type</label>
              <input class="form-control form-control-sm" name="Fueltype" value="<?php echo $doc->fueltype ?>">
            </div>

            <div class="form-group col">
              <label>Colour</label>
              <input class="form-control form-control-sm" name="Colour" value="<?php echo $doc->colour ?>">
            </div>
        </div>

            <div class="form-group row col-md-6">
              <label>Value</label>
              <input class="form-control form-control-sm" name="Value" value="<?php echo $doc->value ?>">
            </div>

          <button type="submit" class="btn btn-primary" name="updateBtn">Update Vehicle</button>
    </form>
</div>
<!-- form ends -->
  
</body>
</html>