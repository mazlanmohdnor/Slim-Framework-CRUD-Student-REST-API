<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

//cors 
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

//mysqli
/*
// 1. get all result
$app->get('/api/students', function () {
    require_once('dbconnect.php');

    $sql = "SELECT * FROM student";
    $result = $con->query($sql);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
});

// 2. get single result
$app->get('/api/students/{id}', function ($request) {
    require_once('dbconnect.php');

    $id = $request->getAttribute('id');

    //create sql statement
    $sql = "SELECT * FROM student WHERE id = $id";
    $result = $con->query($sql);

    $data[] = $result->fetch_assoc();

    echo json_encode($data);
});
// 3. insert data
$app->post('/api/students/add', function ($request) {
    require_once('dbconnect.php');

    //create sql statement
    $sql = "INSERT INTO student (firstname, lastname, matric, email) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    $stmt->bind_param("ssss", $firstname, $lastname, $matric, $email);

    $data = $request->getParsedBody();
    $firstname = $request->getParsedBody()['firstname'];
    $lastname = $request->getParsedBody()['lastname'];
    $matric = $request->getParsedBody()['matric'];
    $matric = $request->getParsedBody()['email'];

    $stmt->execute();
});
// 4. upadate
$app->put('/api/students/update/{id}', function ($request) {
    require_once('dbconnect.php');
    $id = $request->getAttribute('id');

    //create sql statement
    $sql = "UPDATE student SET firstname = ?, lastname = ?, matric = ? WHERE id = $id";
    
    $stmt = $con->prepare($sql);

    $stmt->bind_param("sss", $firstname, $lastname, $matric);

    $data = $request->getParsedBody();
    $firstname = $request->getParsedBody()['firstname'];
    $lastname = $request->getParsedBody()['lastname'];
    $matric = $request->getParsedBody()['matric'];

    $stmt->execute();
});
// 5. delete data
$app->delete('/api/students/delete/{id}', function ($request) {
    require_once('dbconnect.php');
    $id = $request->getAttribute('id');

     $sql = "DELETE from student WHERE id = $id";
     $result = $con->query($sql);
});
*/
//mysqli

//pdo
//get all students
$app->get('/students', function () {
    $sql = "SELECT * FROM student ORDER BY id DESC";
    try {
        require_once('dbconnect.php');
        $stmt = $dbh->query($sql);
        $students = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($students);
    } catch (PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

//get single student
$app->get('/students/{id}', function ($request) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM student WHERE id=".$id;
    try {
        require_once('dbconnect.php');
        $stmt = $dbh->query($sql);
        $students = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($students);
    } catch (PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

//add student
$app->post('/students/add', function ($request) {
    $firstname = $request->getParam('firstname');
    $lastname = $request->getParam('lastname');
    $matric = $request->getParam('matric');
    $email = $request->getParam('email');
    $sql = "INSERT INTO student (firstname, lastname, matric, email) VALUES (:firstname, :lastname, :matric, :email)";
    try {
        require_once('dbconnect.php');
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam("firstname", $firstname);
        $stmt->bindParam("lastname", $lastname);
        $stmt->bindParam("matric", $matric);
        $stmt->bindParam("email", $email);
        $stmt->execute();
      
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

//update
$app->put('/students/update/{id}', function ($request) {
    $id = $request->getAttribute('id');
    
    $firstname = $request->getParam('firstname');
    $lastname = $request->getParam('lastname');
    $matric = $request->getParam('matric');
    $email = $request->getParam('email');

    $sql = "UPDATE student SET firstname=:firstname, lastname=:lastname, matric=:matric, email=:email WHERE id=$id";
    try {
        require_once('dbconnect.php');
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam("firstname", $firstname);
        $stmt->bindParam("lastname", $lastname);
        $stmt->bindParam("matric", $matric);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

//delete record
$app->delete('/students/delete/{id}', function ($request) {
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM student WHERE id=".$id;
    try {
        require_once('dbconnect.php');
    
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dbh = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});
//pdo


$app->run();
