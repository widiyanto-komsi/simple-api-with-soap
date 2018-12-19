<?php
    require_once('lib/nusoap.php');
    $result = array();
    $wsdl = "http://localhost:8080/soap/server.php?wsdl";
    //$wsdl = "http://10.33.34.151/server.php?wsdl";
    $client = new nusoap_client($wsdl, true);
    $err = $client->getError();
    if($err){
        echo "Constructor Error" . $err;
        exit();
    }

    try {
        $result = $client->call('getAllBookData');
        // print_r($result);
        $result = json_decode($result);
    } catch(Exception $e){
        echo "Caught Exception: " .  $e->getMessage() . "\n";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Store Web Service</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Books Store SOAP Web Service</h2>
  
   <br>
   <h2>Book Information</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>ISBN</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if(count($result)){
                for ($i=0; $i < count($result); $i++) { ?>
                    <tr>
                        <td><?php echo $result[$i]->title; ?></td>
                        <td><?php echo $result[$i]->author_name; ?></td>
                        <td><?php echo $result[$i]->price; ?></td>
                        <td><?php echo $result[$i]->isbn; ?></td>
                        <td><?php echo $result[$i]->category; ?></td>
                        <td>
                          <a href="hapus.php?id=<?php echo $result[$i]->id?>">hapus </a>|
                          <a href="edit.php?id=<?php echo $result[$i]->id?>">edit</a>
                        </td>
                    </tr>
            <?php
                }
            }else{ ?>
                <tr>
                    <td colspan='5'>No Data</td>
                </tr>
            <?php } ?>
	</tbody>
  </table>
</div>

</body>
</html>
<script>
  /* setTimeout(function(){
     window.location.reload(1);
  }, 1000); */
</script>