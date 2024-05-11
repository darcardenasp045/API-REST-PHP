<?php
require_once 'database.php';

class Datos extends Database
{
	public function createUsuarioModel($datosModel, $tabla)
	{
		$stmt = $this->getConnection()->prepare("INSERT INTO $tabla (fullname, username, password, secretpin) VALUES (:fullname, :username, :password, :secretpin)");
		$stmt->execute([
			':fullname' => $datosModel['fullname'],
			':username' => $datosModel['username'],
			':password' => $datosModel['password'],
			':secretpin' => $datosModel['secretpin']
		]);

		return $stmt->rowCount() > 0;
	}

	public function readUsuarioModel($tabla, $id = null)
	{
		$sql = $id !== null ? "SELECT id, fullname, username, password, secretpin FROM $tabla WHERE id = :id" : "SELECT id, fullname, username, password, secretpin FROM $tabla";

		$stmt = $this->getConnection()->prepare($sql);

		if ($id !== null) {
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		}

		$stmt->execute();

		$usuarios = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row = array_map('utf8_encode', $row);
			$usuarios[] = $row;
		}

		return $usuarios;
	}

	public function deleteUsuarioModel($id, $tabla)
	{
		$stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() > 0;
	}

	public function updateUsuarioModel($datosModel, $tabla)
	{
		$stmt = $this->getConnection()->prepare("UPDATE $tabla SET fullname = :fullname, username = :username, password = :password, secretpin = :secretpin WHERE id = :id");
		$stmt->execute([
			':id' => $datosModel['id'],
			':fullname' => $datosModel['fullname'],
			':username' => $datosModel['username'],
			':password' => $datosModel['password'],
			':secretpin' => $datosModel['secretpin']
		]);

		return $stmt->rowCount() > 0;
	}

}

?>