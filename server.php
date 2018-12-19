<?php
    require_once('dbconn.php');
    require_once('lib/nusoap.php');
    $server = new nusoap_server();

     function getAllBookData(){
            global $dbconn;
            $sql = "select id, title, author_name, price, isbn, category FROM books";
            // prepare sql and bind paramaters
            $stmt = $dbconn->prepare($sql);
            // insert a row
            $stmt->execute();
            $data = $stmt->fetchAll();
            return json_encode($data);
            $dbconn = null;
    }

    function getBookData($id){
            global $dbconn;
            $sql = "select id, title, author_name, price, isbn, category FROM books WHERE id='$id'";
            // prepare sql and bind paramaters
            $stmt = $dbconn->prepare($sql);
            // insert a row
            $stmt->execute();
            $data = $stmt->fetchAll();
            return json_encode($data);
            $dbconn = null;
    }

    function insertBook($title,$author_name,$price,$isbn,$category){
        global $dbconn;
        $sql = "insert into books(title,author_name,price,isbn,category) VALUES ('$title','$author_name','$price','$isbn','$category')";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return json_encode($data);
        $dbconn = null;
    }

     function updateBook($title,$author_name,$price,$isbn,$category,$id){
        global $dbconn;
        $sql = "UPDATE books SET title='$title',author_name='$author_name',price='$price',isbn='$isbn',category='$category' WHERE id='$id'";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return "data berhasil diubah";
        $dbconn = null;
    }

    function deleteBook($id){
        global $dbconn;
        $sql = "DELETE FROM books WHERE id = $id";
        
        $stmt = $dbconn->prepare($sql);
        // insert a row
        $stmt->execute();
        return "data berhasil dihaspus";
        $dbconn = null;
    }

    $server->configureWSDL('Toko Buku', 'urn:book');
    $server->register('getAllBookData',
            array('params' => 'xsd:'), //parameter
            array('data' => 'xsd:Array'), //output
            'urn:book', //namespace
            'urn:book#getAllBookData' //soapaction
            );
    $server->register('getBookData',
            array('id' => 'xsd:String'), //parameter
            array('data' => 'xsd:Array'), //output
            'urn:book', //namespace
            'urn:book#getBookData' //soapaction
            );

    $server->register('insertBook',
            array('title' => 'xsd:String', 'author_name' => 'xsd:String', 'price' => 'xsd:String', 'isbn' => 'xsd:String', 'category' => 'xsd:String'), //parameter
            array('status' => 'xsd:String'), //output
            'urn:book', //namespace
            'urn:book#insertBook' //soapaction
            );

    $server->register('updateBook',
            array('title' => 'xsd:String', 'author_name' => 'xsd:String', 'price' => 'xsd:String', 'isbn' => 'xsd:String', 'category' => 'xsd:String', 'id' => 'xsd:String'), //parameter
            array('status' => 'xsd:String'), //output
            'urn:book', //namespace
            'urn:book#updateBook' //soapaction
            );

    $server->register('deleteBook',
            array('id' => 'xsd:String'),  //parameter
            array('status' => 'xsd:String'),  //output
            'urn:book',   //namespace
            'urn:book#deleteBook' //soapaction
            );

    $server->service(file_get_contents("php://input"));

?>