<?php
require_once 'modelojson.php';

class ControllerJson
{
	private $datos;

	public function __construct()
	{
		$this->datos = new Datos();
	}

	public function createUsuarioController($fullname, $username, $password, $secretpin)
	{
		$datosController = array(
			"fullname" => $fullname,
			"username" => $username,
			"password" => $password,
			"secretpin" => $secretpin
		);
		return $this->datos->createUsuarioModel($datosController, "users");
	}

	public function readUsuariosController($id = null)
	{
		$usuarios = $this->datos->readUsuarioModel("users");

		if ($id !== null) {
			$usuarios = array_filter($usuarios, function ($usuario) use ($id) {
				return $usuario['id'] == $id;
			});
		}

		return $usuarios;
	}

	public function deleteUsuarioController($id)
	{
		return $this->datos->deleteUsuarioModel($id, "users");
	}

	public function updateUsuarioController($id, $fullname, $username, $password, $secretpin)
	{
		$datosController = array(
			"id" => $id,
			"fullname" => $fullname,
			"username" => $username,
			"password" => $password,
			"secretpin" => $secretpin
		);
		return $this->datos->updateUsuarioModel($datosController, "users");
	}
}

?>