<?php
function openmysqli(): mysqli {
    $connection = new mysqli('Data', 'user', 'password', 'appDB');
    return $connection;
}
function outputStatus($status, $message)
{
    echo '{status: ' . $status . ', message: "' . $message . '"}';
}
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addUser();
            break;
        case 'DELETE':
            removeUser();
            break;
        case 'PATCH':
            updateUserPassword();
            break;
        case 'GET':
            getUserByID();
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
}
catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
};

function addUser() {
    $data = json_decode(file_get_contents('php://input'), True);
    
    if (!isset($data['name']) || !isset($data['surname'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrName = $data['name'];
    $usrPass = $data['surname'];
    $result = $mysqli->query("SELECT * FROM users WHERE name = '{$usrName}';");
    if ($result->num_rows === 1) {
        $message = 'User '. $usrName . ' already exists';
        outputStatus(1, $message);
    } else {
        $query = "INSERT INTO users (name, surname)
        VALUES ('" . $usrName . "', '" . $usrPass . "');";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Added user ' . $usrName;
        outputStatus(0, $message);
    }
}
function removeUser()
{
    if (!isset($_GET['id'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrID = $_GET['id'];
    $result = $mysqli->query("SELECT * FROM users WHERE ID = '{$usrID}';");
    if ($result->num_rows === 1) {
        $query = "DELETE FROM users WHERE ID = '" . $usrID . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Removed user ' . $usrID;
        outputStatus(0, $message);
    } else {
        $message = 'User ' . $usrID . ' does not exist';
        outputStatus(1, $message);
    }
}
function updateUserPassword()
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['name']) || !isset($data['surname'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrName = $data['name'];
    $usrPass = $data['surname'];
    $result = $mysqli->query("SELECT * FROM users WHERE name = '{$usrName}';");
    if ($result->num_rows === 1) {
        $query = "UPDATE users SET surname = '" . $usrPass . "' WHERE name = '" . $usrName . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Changed surname for ' . $usrName;
        outputStatus(0, $message);
    } else {
        $message = $usrName . ' does not exist';
        outputStatus(1, $message);
    }
}
function getUserByID()
{
    if (!isset($_GET['id'])) {
        $mysqli = openMysqli();
        $result = $mysqli->query("SELECT * FROM users;");
        echo "{\nstatus: 0\n";
        foreach ($result as $info) {
            echo"name: '" . $info['name'] . "', surname: '" . $info['surname'] . "';\n";
        }
        echo "}";
        $mysqli->close();
    }
    else {
        $mysqli = openMysqli();
        $usrID = $_GET['id'];
        $result = $mysqli->query("SELECT * FROM users WHERE ID = '{$usrID}';");
        if ($result->num_rows === 1) {
            foreach ($result as $info) {
                echo "{status: 0, name: '" . $info['name'] . "', surname: '" . $info['surname'] . "';}";
            }
            $mysqli->close();
        } else {
            $message = 'User ID '. $usrID . ' does not exist';
            outputStatus(1, $message);
        }
    }
}
?>