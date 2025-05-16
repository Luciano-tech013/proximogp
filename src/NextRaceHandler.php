<?php

class NextRaceHandler {
    public function __construct(
        private DateTime $currentDate,
    )
    {}

    public function get_next_race(array $races) {
        $today = $this->currentDate;

        foreach ($races as $race) {
            $fp1DateString = $race['schedule']['fp1']['date'] ?? null;

            //Si no tiene fecha, salteo
            if(!$fp1DateString) 
                continue;
            
            //Fecha de inicio del GP (viernes)
            $start = (new DateTime($fp1DateString))->setTime(0, 0, 0);

            //Fecha de fin del GP (domingo): +2 días
            $end = $start->modify('+2 days')->setTime(23, 59, 59);
    
            //Si hoy está dentro del fin de semana del GP, devuelvo ese GP
            if($today >= $start && $today <= $end)
                return $race;
    
            //Si el GP aún no empezó (y no estamos en su fin de semana), devuelvo el próximo
            if($start > $today)
                return $race;
        }
        
        //NO hay mas carreras
        return null;
    }
    
    //Devuelve el intervalo de dias entre las fechas
    public function get_count_days($nextRace): int {
        $dateString = $nextRace['schedule']['fp1']['date'] ?? null;
    
        if(empty($dateString)) 
            return -1;
    
        $raceDate = new DateTime($dateString);
        
        return $this->currentDate->diff($raceDate)->days;
    }

    public function get_message(int $days): string {
        return match(true) {
            $days == 0 => "<span class='race__days__today'>¡Es hoy!</span>",
            $days == 1 => "Falta <span class='race__days__upcoming'>$days dia</span> para el Gran Premio",
            default => "Faltan <span class='race__days__upcoming'>$days dias</span> para el Gran Premio"
        };
    }
}