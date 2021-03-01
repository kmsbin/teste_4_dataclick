<?php
    require_once('todoDao.php');

    $data = json_decode(file_get_contents('php://input'), true);
    
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset=UTF-8");
    
    header('Access-Control-Allow-Methods: *');
    $daoConn = new TodoDao();
    // $post = $_POST['name'];
    if (isset($_REQUEST)) {
        // var_dump($data);
        // var_dump($data['POST']);
    }
    $row = array(
        'title' => '',
        'description' => '',
        'priority' => 0
    );
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $isRunQuery = true;
            foreach ($row as $key => $value) {
                if (!isset($data[$key]) || empty(($data[$key]))) {
                    echo json_encode(array(
                        'status'=> 0,
                        'msg' => 'tarefa não cadastrada',
                    ));
                    $isRunQuery = false; 
                    return; 
                }
                $row[$key] = $data[$key];

            }
            if ($isRunQuery) { 
                $daoConn->create($row);
                echo json_encode(array(
                    'status'=> 1,
                    'msg' => 'tarefa cadastrada',
                ));
            } 
            break;
        case 'GET':

            echo json_encode($daoConn->findAll());
            break;
        case 'PUT':
            $put = array(
                'id' => 0,
                'title' => '',
                'description' => '',
                'priority' => 0
            );
            $isRunQuery = true;
            foreach ($put as $key => $value) {
                if (!isset($data[$key]) || empty(($data[$key]))) {
                    echo "items errados";
                    echo json_encode(array(
                        'status'=> 0,
                        'msg' => 'parametros insuficientes ou errados',
                    ));
                    $isRunQuery = false; 
                    return; 
                }
                $put[$key] = $data[$key];

            }
            if($isRunQuery) {
                $daoConn->update($put);
                echo json_encode(array(
                    'status'=> 1,
                    'msg' => 'tarefa atualizada',
                ));
            }

            
            break;
        case 'DELETE':
            if (isset($data['id'])) {
                $daoConn->delete($data['id']);    
                echo json_encode(array(
                    'status'=> 1,
                    'msg' => 'tarefa deletada',
                ));
            }
            break;    
        default:
            
            break;
    }
    // echo $daoConn->update(1, 'novo titulo', 'é esse é o novo titulo cara', 50);
    // echo $daoConn->find(1)['title'];

?>