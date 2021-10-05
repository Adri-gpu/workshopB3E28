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
            if($c == 5)
            {
                echo "</br>";
                $c = 0;
            }
            echo "<p class=\"buttonDay\">" . $i + 1 . "</p>";
            $c++;
            $i++;
        }
    }

    private function showMonths($months)
    {
        switch ($months) {
            case '1':
                return "Janvier";
                break;
            case '2':
                return "Février";
                break;
            case '3':
                return "Mars";
                break;
            case '4':
                return "Avril";
                break;
            case '5':
                return "Mai";
                break;
            case '6':
                return "Juin";
                break;
            case '7':
                return "Juillet";
                break;
            case '8':
                return "Août";
                break;
            case '9':
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