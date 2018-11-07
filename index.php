<?php
session_start();

//An autoloader is required to import PHPonCouch classes
$autoloader = join(DIRECTORY_SEPARATOR,[__DIR__,'vendor','autoload.php']);
require $autoloader;

// import classes 
use PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;

//create a client to access the database
$client = new CouchClient('http://Eoin:gesq4qxq@localhost:5984','vehicles');

//insert function
if(isset($_POST["createBtn"])){

   $new_doc = new stdClass();
   $new_doc->make = $_POST["make"];
   $new_doc->model = $_POST["model"];
   $new_doc->year = $_POST["year"];
   $new_doc->enginesize = $_POST["enginesize"];
   $new_doc->fueltype = $_POST["fueltype"];
   $new_doc->colour = $_POST["colour"];
   $new_doc->value= $_POST["value"];
   try {
    $response = $client->storeDoc($new_doc);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
}

//Update function
if(isset($_POST["updateBtn"])){
    try {
        $doc = $client->getDoc($_POST["updateID"]);
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")<br>\n";
    }
   
        $doc->make = $_POST["Make"];
        $doc->model = $_POST["Model"];
        $doc->year = $_POST["Year"];
        $doc->enginesize = $_POST["Enginesize"];
        $doc->fueltype = $_POST["Fueltype"];
        $doc->colour = $_POST["Colour"];
        $doc->value= $_POST["Value"];
    
    try {
        $response = $client->storeDoc($doc);
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")<br>\n";
    }
}

//Delete function
if(isset($_POST["deleteBtn"])){
//Get doc
try {
    $doc = $client->getDoc($_POST["deleteBtn"]);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
//Delete doc
try {
    $client->deleteDoc($doc);
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
}
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
  
    <div class="container">
    <table class="table table-striped" method="get">
      <thead>
        <tr>
          <th>Make</th>
          <th>Model</th>
          <th>Year</th>
          <th>Engine Size</th>
          <th>Fuel Type</th>
          <th>Colour</th>
          <th>Value</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
 
        <?php
        //Get all Documents
         $all_docs = $client->getAllDocs();
         foreach($all_docs->rows as $row){
         try {
        //Get row id's
         $doc = $client->getDoc($row->id);
         } catch ( Exception $e ) {
           if ( $e->getCode() == 404 ) {
              echo "No Document Found!";}
           exit(1);
         }
         //Display each field for each document.
         echo '<tr><td>'.$doc->make. '</td><td>' .$doc->model. '</td><td>' .$doc->year. '</td><td>' .$doc->enginesize. '</td><td>' 
         .$doc->fueltype. '</td><td>' .$doc->colour. '</td><td>' .$doc->value. '</td>';
         echo 
         //Display buttons beside each row for easy access.
         "<td>
         <form method='post' action='updateCar.php'><button name='ID' value='$row->id'><i class='fa fa-pencil'></i></button></form>
         <form method='post' action='index.php'><button name='deleteBtn' value='$row->id'><i class='fa fa-trash'></i></button></form>
         </td>"; 
        }
         ?>
        
      </tr>
      </tbody>
      </table>
      
      

      <!-- Modal Open Button -->
  <div class="container-fluid"><div class="float-right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Vehicle</button></div>
  </div>
  <!--Links modal to button -->
  <div id="myModal" class="modal fade" role="dialog">

  <!-- Configuring modal -->
  <div class="modal-dialog">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Vehicle Form</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>   
    </div>

<!-- Modal Body -->
<div class="modal-body">
<!-- Form Begins -->
  <div class="container">
    <form role="form" method="POST" action="index.php">
        <div class="row">
            <div class="form-group col">
              <label>Make</label>
              <input  class="form-control form-control-sm" placeholder="Make" name="make"> 
            </div>
            <div class="form-group col">
              <label>Model</label>
              <input class="form-control form-control-sm" placeholder="Model" name="model">
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
              <label>Year</label>
              <input class="form-control form-control-sm" placeholder="Year" name="year">
            </div>
            <div class="form-group col">
              <label>Engine Size</label>
              <input class="form-control form-control-sm" placeholder="Engine Size" name="enginesize">
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
              <label>Fuel Type</label>
              <input class="form-control form-control-sm" placeholder="Fuel Type" name="fueltype">
            </div>
            <div class="form-group col">
              <label>Colour</label>
              <input class="form-control form-control-sm" placeholder="Colour" name="colour">
            </div>
        </div>
            <div class="form-group row col-md-6">
              <label>Value</label>
              <input class="form-control form-control-sm" placeholder="Value" name="value">
            </div>
            <button type="submit" class="btn btn-primary" name="createBtn">Add Vehicle</button>
    </form>

  <div class="modal-footer">
  <button type="cancel" class="btn btn-secondary" name="closeModal" data-dismiss="modal">Close</button>
  </div>
<!-- Form Ends -->
</div>
<!-- Modal Ends -->
</div>

     

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
  </body>

</html>
