<?php

// Definición de la clase HomeController
class HomeController {
    // Propiedades públicas para almacenar el título y la URL base
    public $titulo;
    public $base_url;

    // Constructor de la clase que inicializa las propiedades
    public function __construct($titulo = "SYS BETCOM", $base_url = "http://gestionclientes.com/") {
        // Asigna los valores de los parámetros a las propiedades de la clase
        $this->titulo = $titulo;
        $this->base_url = $base_url;
    }   

    // Método para obtener el valor de la propiedad $titulo
    public function getTitulo() {
        return $this->titulo;
    }

    // Método para obtener el valor de la propiedad $base_url
    public function getBaseUrl() {
        return $this->base_url;
    }

    // Método para renderizar una vista
    public function render($view, $data = []) {
        // Convierte los elementos del array $data en variables individuales
        extract($data);
        // Incluye el archivo de vista correspondiente
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
?>