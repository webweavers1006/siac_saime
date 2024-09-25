<?php
if (isset($_POST["archivo"])) {
    $targetDir = "/var/www/html/salasituacional/public/documentos_casos/"; // Directorio donde se guardarán los archivos subidos
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo (opcional)
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo (puedes personalizar esta lista)
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Solo se permiten archivos PDF, DOC y DOCX.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado en 0 por algún error
    if ($uploadOk == 0) {
        echo "El archivo no se pudo subir.";
    } else {
        // Subir archivo al directorio especificado
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "El archivo " . basename($_FILES["fileToUpload"]["name"]) . " se ha subido correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    }
}
