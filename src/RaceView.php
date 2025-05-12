<?php

class RaceView {
    public function render(string $template, array $data): void {
        //Obtiene las propiedades del para que el template las pueda usar
        extract($data);

        require_once __DIR__ . "/templates/$template";
    }
}