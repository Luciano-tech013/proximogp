<?php
require_once __DIR__ . "/../src/Content.php";
require_once __DIR__ . "/../src/NextRaceHandler.php";
require_once __DIR__ . "/../src/RaceView.php";

$currentDate = new DateTime();

$nextRaceHandler = new NextRaceHandler($currentDate);
$view = new RaceView();

//Obtiene las carreras de la temporada actual
$content = Content::get_races();

$races = $content["races"];

if(empty($races)) {
    $view->render("error.php", [
        "error" => "¡Ups!. Ocurrió un error. Intenta más tarde"
    ]);
    return;
}
    
//Obtiene la próxima carrera y los dias faltantes
$nextRace = $nextRaceHandler->get_next_race($races);

if(empty($nextRace)) {
    $view->render("error.php", [
        "error" => "¡Ya no existe una próxima carrera!. ¡La temporada ya ah finalizado!"
    ]);
    return;
}

//Obtiene los dias faltantes para esa carrera
$countDays = $nextRaceHandler->get_count_days($nextRace);

if($countDays == -1) {
    $view->render("error.php", [
        "error" => "¡Ups!. El contador de dias ah salido mal. Vuelve a intentar mas tarde"
    ]);
    return;
}

$messageDays = $nextRaceHandler->get_message($countDays);

$view->render("header.php", []);

$view->render("main.php", [
    "info" => "Ronda {$nextRace['round']}: {$nextRace['raceName']}",
    "message" => $messageDays,
    "circuit" => "Circuito: {$nextRace['circuit']['circuitName']}",
    "date" => "Fecha: {$nextRace['schedule']['fp1']['date']}"
]);








