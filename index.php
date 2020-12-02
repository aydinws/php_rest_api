<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once 'db.php';
    include_once 'user.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    $cmd = $_GET['cmd'];

    if($cmd == 'add_user')
    {

        header('Access-Control-Allow-Methods: POST');
    
        $datas = json_decode(file_get_contents("php://input"));

        $user->name = $datas->name;
        $user->surname = $datas->surname;
        $user->username = $datas->username;
        $user->email = $datas->email;
        $user->password = $datas->password;

        if($user->add_user()) 
        {
            echo json_encode(array('message' => 'User created'));
        } 
        else 
        {
            echo json_encode(array('message' => 'User not created'));
        }
    
    }

    if($cmd == 'get_one_user')
    {

        $user->id = $_GET['id'];

        $user->get_one_user();

        $user_arr = array(
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'username' => $user->username,
            'email' => $user->email,
        );

        echo json_encode($user_arr);

    }

    if($cmd == 'get_users')
    {

        $result = $user->get_users();
        $num = $result->rowCount();

        if($num > 0) 
        {
            $users_arr = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                extract($row);

                $user_item = array(
                    'id' => $id,
                    'name' => $name,
                    'surname' => $surname,
                    'username' => $username,
                    'email' => $email,
                );

            array_push($users_arr, $user_item);
            }

            echo json_encode($users_arr);

        } 
        else 
        {
            echo json_encode(array('message' => 'No user found'));
        }

    }

    if($cmd == 'update_user')
    {

        header('Access-Control-Allow-Methods: PUT');

        $datas = json_decode(file_get_contents("php://input"));

        $user->id = $datas->id;
        $user->name = $datas->name;
        $user->surname = $datas->surname;
        $user->username = $datas->username;

        if($user->update_user()) 
        {
            echo json_encode(array('message' => 'User updated'));
        } 
        else 
        {
            echo json_encode(array('message' => 'User not updated'));
        }

    }

    if($cmd == 'delete_user')
    {

        header('Access-Control-Allow-Methods: DELETE');

        $datas = json_decode(file_get_contents("php://input"));

        $user->id = $datas->id;

        if($user->delete_user()) 
        {
            echo json_encode(array('message' => 'User deleted'));
        }
        else 
        {
            echo json_encode(array('message' => 'User not deleted'));
        }

    }

?>