<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
require_once 'controllerjson.php';

$apicall = isset($_GET['apicall']) ? $_GET['apicall'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $apicall !== 'readusuario') {
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  if ($data === null) {
    $response = array(
      'error' => true,
      'message' => 'Error en el contenido JSON',
    );
  } else {
    $db = new ControllerJson();

    switch ($apicall) {
      //POST: http://localhost/../api.php?apicall=createusuario + Body(Json)
      case 'createusuario':
        $fullname = $data['fullname'];
        $username = $data['username'];
        $password = $data['password'];
        $secretpin = $data['secretpin'];

        $result = $db->createUsuarioController($fullname, $username, $password, $secretpin);

        if ($result) {
          $response['error'] = false;
          $response['message'] = 'Usuario agregado correctamente';
          $response['contenido'] = $db->readUsuariosController();
        } else {
          $response['error'] = true;
          $response['message'] = 'Ocurrió un error, intenta nuevamente';
        }
        break;

      default:
        $response['error'] = true;
        $response['message'] = 'Llamado Inválido del API';
        break;
    }
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $apicall === 'readusuario') {
  $db = new ControllerJson();

  if (empty($id)) {
    $response['error'] = false;
    $response['message'] = 'Solicitud completada correctamente';
    $response['contenido'] = $db->readUsuariosController();
    //http://localhost/../api.php?apicall=readusuario
  } 
  
}else if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $apicall === 'deleteusuario')
{
  $db = new ControllerJson();
  $result = $db->deleteUsuarioController($id);

  if ($result) {
    $response['error'] = false;
    $response['message'] = 'Usuario eliminado correctamente';
    $response['contenido'] = $db->readUsuariosController();
    //http://localhost/../api.php?apicall=deleteusuario&id=1
  } else {
    $response['error'] = true;
    $response['message'] = 'Ocurrió un error, intenta nuevamente';
  }
} else if ($_SERVER ['REQUEST_METHOD'] === 'PUT' && $apicall === 'updateusuario'){
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  if ($data === null) {
    $response = array(
      'error' => true,
      'message' => 'Error en el contenido JSON',
    );
  } else {
    $db = new ControllerJson();

    $id = $data['id'];
    $fullname = $data['fullname'];
    $username = $data['username'];
    $password = $data['password'];
    $secretpin = $data['secretpin'];

    $result = $db->updateUsuarioController($id, $fullname, $username, $password, $secretpin);

    if ($result) {
      $response['error'] = false;
      $response['message'] = 'Usuario actualizado correctamente';
      $response['contenido'] = $db->readUsuariosController();
      //http://localhost/../api.php?apicall=updateusuario
      //{
      //  "id": 1,
      //  "fullname": "Juan Perez",
      //  "username": "juanperez",
      //  "password": "123456",
      //  "secretpin": "1234"
      //}
      } else {
      $response['error'] = true;
      $response['message'] = 'Ocurrió un error, intenta nuevamente';
    }
  }

}
 else {
  $response['error'] = true;
  $response['message'] = 'Método de solicitud no válido';
}

echo json_encode($response);
?>