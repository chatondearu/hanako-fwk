<?php
class Start_Handler
{
    public $cards = array(
        /*TREFLE*/
        '2C','3C','4C','5C','6C','7C','8C','9C','TC','JC','QC','KC','AC',
        /*PIQUE*/
        '2S','3S','4S','5S','6S','7S','8S','9S','TS','JS','QS','KS','AS',
        /*COEUR*/
        '2H','3H','4H','5H','6H','7H','8H','9H','TH','JH','QH','KH','AH',
        /*CARREAU*/
        '2D','3D','4D','5D','6D','7D','8D','9D','TD','JD','QD','KD','AD'
    );

    public function get($data,$server){

        $randStart = 0;
        $randEnd = sizeof($this->cards)-1;

        $Done = $this->cards;

        //Mélange des cartes et mise en session
        for($index = $randStart; $index <= $randEnd; $index++){
            $newPlace = rand($randStart,$randEnd);
            $lastPlace = $index;
            $lastVal = $Done[$lastPlace];
            $newVal = $Done[$newPlace];
            $Done[$lastPlace] = $newVal;
            $Done[$newPlace] = $lastVal;
        }

        //Generate Hands
        for($index = 0;  $index < 13; $index++){
            $key = array_search(array_shift($Done),$this->cards);
            $this->cards[$key]='N';
            $key = array_search(array_shift($Done),$this->cards);
            $this->cards[$key]='W';
            $key = array_search(array_shift($Done),$this->cards);
            $this->cards[$key]='S';
            $key = array_search(array_shift($Done),$this->cards);
            $this->cards[$key]='E';
        }

        $str='';
        for($index = 0; $index <= $randEnd; $index++){
            $str .= $this->cards[$index];
        }

        return json_encode($str);

    }

    public function bouchon($data,$server){
        $json ='{
    "tournament":{
        "id":747477,
        "category":"TRAINING",
        "number":747405,
        "dateCreation":"08/10/2012 - 17:23:19",
        "dateStart":"08/10/2012 - 17:00:00",
        "dateEnd":"08/10/2012 - 17:00:00",
        "finished":true,
        "engine":622,
        "nbDeal":1,
        "nbPlayer":30
    },
    "deal":{
        "id":1426639,
        "index":1,
        "nbPlayer":30,
        "scoreAverage":-6.0,
        "distribution":"NSWWWSSENSSSNSNEWEEENNWWENNWESNWSEENWWWWSESNSNWEEENS",
        "dealer":"N",
        "vulnerabiliy":"A",
        "paramGeneration":"indifferent1"
    },
    "game":{
        "id":42602677,
        "finished":true,
        "dateStart":"08/10/2012 - 17:25:59",
        "dateLast":"08/10/2012 - 17:36:12",
        "contract":"1H",
        "declarer":"W",
        "contractType":1,
        "nbTricks":6,
        "score":100,
        "conventions":"NOVICE - 0103010000000000000000000",
        "bids":"1DN-PAE-PAS-1HW-PAN-PAE-PAS",
        "cards":"6SN-4SE-ASS-2SW-3CS-5CW-TCN-9CE-ADN-4DE-2DS-5DW-TDN-6DE-5HS-QDW-3SS-9SW-KSN-TSE-3DN-7DE-8HS-JDW-5SS-KHW-8SN-JSE-QHW-2HN-4HE-7CS-3HW-JHN-9HE-8CS-2CN-THE-JCS-6CW-KDE-QCS-4CW-9DN-!W",
        "deviceID":1
    }
}';
        $json = json_decode($json);
        return json_encode($json);
    }
}