<?php
class Response {
    // Método para establecer el código de estado HTTP
    public static function status($code) {
        http_response_code($code);
        return new self(); // Devuelve una nueva instancia de Response
    }

    // Método para enviar datos como respuesta
    public static function send($data) {
        // Configurar el tipo de contenido a JSON
        header('Content-Type: application/json');

        // Convertir la variable a JSON y enviar como respuesta
        echo json_encode($data);
        exit; // Asegúrate de detener la ejecución después de enviar la respuesta
    }

    // Método para enviar un archivo
    public static function file($filePath) {
        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            http_response_code(404);
            echo json_encode(['error' => 'Archivo no encontrado']);
            exit;
        }

        // Configurar los encabezados para la descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Limpiar el búfer de salida antes de enviar el archivo
        ob_clean();
        flush();
        
        // Leer el archivo y enviarlo al cliente
        readfile($filePath);
        exit; // Asegúrate de detener la ejecución después de enviar el archivo
    }

    // Método para enviar datos en base64
    public static function base64($base64String, $fileName) {
        // Decodificar el string base64
        $data = base64_decode($base64String);

        // Verificar si la decodificación fue exitosa
        if ($data === false) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos base64 inválidos']);
            exit;
        }

        // Configurar los encabezados para la descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($data));

        // Limpiar el búfer de salida antes de enviar los datos
        ob_clean();
        flush();

        // Enviar los datos decodificados al cliente
        echo $data;
        exit; // Asegúrate de detener la ejecución después de enviar los datos
    }
}