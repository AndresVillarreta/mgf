<?php


class Model {
    protected static $connection;

    // Método estático para conectar a la base de datos
    protected static function connect() {
        if (!self::$connection) {
            $host = DB_HOST; // Cambia según tu configuración
            $db = DB_NAME; // Nombre de tu base de datos
            $user = DB_USER; // Usuario de la base de datos
            $pass = DB_PASS; // Contraseña de la base de datos

            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
                exit; // Salir si no se puede conectar
            }
        }
    }

    // Método para ejecutar una consulta SQL
    protected static function query($sql, $params = []) {
        self::connect(); // Asegúrate de que la conexión esté establecida
        $stmt = self::$connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Método para obtener todos los registros
    public static function all($table) {
        $stmt = self::query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function join($table1, $table2, $on, $conditions = '', $params = []) {
        $sql = "SELECT * FROM $table1 INNER JOIN $table2 ON $on";
    
        if ($conditions) {
            $sql .= " WHERE $conditions";
        }
    
        return self::query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Método para obtener un registro por su ID
    public static function find($table, $id) {
        $stmt = self::query("SELECT * FROM $table WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para insertar un registro
    public static function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ':' . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        self::query($sql, $data);
        return self::$connection->lastInsertId();
    }

    // Método para actualizar un registro
    public static function update($table, $data, $id) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $setString = implode(", ", $set);
        $sql = "UPDATE $table SET $setString WHERE id = :id";
        $data['id'] = $id; // Añadir el ID a los parámetros
        self::query($sql, $data);
    }

    // Método para eliminar un registro
    public static function delete($table, $id) {
        self::query("DELETE FROM $table WHERE id = ?", [$id]);
    }

    // Método para manejar transacciones
    public static function transaction(callable $callback) {
        self::connect(); // Asegúrate de que la conexión esté establecida
        self::$connection->beginTransaction();
        try {
            $callback();
            self::$connection->commit();
        } catch (Exception $e) {
            self::$connection->rollBack();
            throw $e; // Relanzar la excepción después de hacer rollback
        }
    }

    // Cierre de la conexión (opcional, ya que PDO lo maneja automáticamente al finalizar el script)
    public function __destruct() {
        self::$connection = null;
    }
}
