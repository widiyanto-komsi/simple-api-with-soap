<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Store Web Service</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Books Store SOAP Web Service</h2>
  <form method="post">
    <div class="form-group">
      <label for="title">Title :</label>
      <input type="text" class="form-control" placeholder="Enter title" name="title">
    </div>

    <div class="form-group">
      <label for="author_name">Author :</label>
      <input type="text" class="form-control" placeholder="Enter author" name="author_name">
    </div>

    <div class="form-group">
      <label for="price">Price :</label>
      <input type="text" class="form-control" placeholder="Enter price" name="price">
    </div>

    <div class="form-group">
      <label for="isbn">ISBN :</label>
      <input type="text" class="form-control" placeholder="Enter ISBN" name="isbn">
    </div>

    <div class="form-group">
      <label for="category">Category :</label>
      <input type="text" class="form-control" placeholder="Enter category" name="category">
    </div>
    <input type="submit" name="aksi" value="tambah" class="btn btn-default">
  </form>
</div>

</body>
</html>

<?php
    if(@$_POST['aksi'] == 'tambah'){
        require_once('lib/nusoap.php');
        //$wsdl = "http://10.33.34.151/server.php?wsdl";
        $wsdl = "http://localhost:8080/soap/server.php?wsdl";
        $client = new nusoap_client($wsdl, true);
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2>' . $err;
            exit();
        }
        try {
            $title = $_POST['title'];
            $author_name = $_POST['author_name'];
            $price = $_POST['price'];
            $isbn = $_POST['isbn'];
            $category = $_POST['category'];
           
            $result = $client->call('insertBook',array($title,$author_name,$price,$isbn,$category));
            //print_r($result);
            return json_encode($result);
            //print_r($result);
        }catch(Exception $e) {
            echo 'Caught exception: '.$e->getMessage()."\n";
        }
    }
?>