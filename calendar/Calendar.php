<?php

class Calendar
{

    public function __construct($year, $months)
    {
        $this->showDays($year, $months);
    }

    public function addEvent()
    {

    }

    public function deleteEvent()
    {

    }

    private function showDays($year, $months)
    {
        echo $this->showMonths($months) . " " . $this->showYears($year) . "</br>";
        $daysNumber = cal_days_in_month(CAL_GREGORIAN, $months, $year);
        $i = 0;
        $c = 0;
        while($i < $daysNumber)
        {
            if($i < 9)
                $class = "buttonDay";
            else
                $class = "buttonDay10";
            if($c == 5)
            {
                echo "</br>";
                $c = 0;
            }
            echo "<button class=\"" . $class . "\">" . $i + 1 . "</button>";
            $c++;
            $i++;
        }
    }

    private function showMonths($months)
    {
        switch ($months) {
            case '01':
                return "Janvier";
                break;
            case '02':
                return "Février";
                break;
            case '03':
                return "Mars";
                break;
            case '04':
                return "Avril";
                break;
            case '05':
                return "Mai";
                break;
            case '06':
                return "Juin";
                break;
            case '07':
                return "Juillet";
                break;
            case '08':
                return "Août";
                break;
            case '09':
                return "Septembre";
                break;
            case '10':
                return "Octobre";
                break;
            case '11':
                return "Novembre";
                break;
            case '12':
                return "Décembre";
                break;
            default:
                return "Erreur";
                break;
        }
    }

    private function showYears($year)
    {
        return $year;
    }
}