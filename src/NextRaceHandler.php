<?php

class NextRaceHandler {
    public function __construct(
        private DateTime $currentDate
    )
    {}

    public function get_next_race(array $races) {
        foreach($races as $race) {
            $dateString = $race["schedule"]["fp1"]["date"];

            if(!$dateString)
                continue;

            //Lo convierto a DateTime para poder comparar
            $raceDate = new DateTime($dateString);
            
            if($raceDate >= $this->currentDate) {
                return $race;
            }
        }
    
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
            $days == 0 => "¡Es hoy!",
            $days == 1 => "Falta <span>$days dia</span> para el Gran Premio",
            default => "Faltan <span>$days dias</span> para el Gran Premio"
        };
    }
}