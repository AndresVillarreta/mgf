<?php

class User extends Model
{
    protected static $table = 'users';
    
    // Método para obtener todos los usuarios
    public static function getAllUsers()
    {
        return self::all(self::$table);
    }

    // Método para obtener un usuario por ID
    public static function getUserById($id) // Cambiado a static
    {
        return self::find(self::$table, $id);
    }

    // Método para crear un nuevo usuario
    public static function createUser($data) // Cambiado a static
    {
        return self::create(self::$table, $data);
    }

    // Método para actualizar un usuario
    public static function updateUser($data, $id) // Cambiado a static
    {
        return self::update(self::$table, $data, $id);
    }

    // Método para eliminar un usuario
    public static function deleteUser($id) // Cambiado a static
    {
        return self::delete(self::$table, $id);
    }
}
