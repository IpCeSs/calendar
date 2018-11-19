<?php
namespace App\Date;

class Month
{
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    /**
     * Undocumented function
     *
     * @param string $month between 1 and 12
     * @param string $year must be above 1970
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }
        if ($year === null) {
            $year = intval(date('Y'));
        }
        // if ($month < 1 || $month > 12) {
        //     throw new \Exception("Le Mois $month n'est pas valide.");
        // }
        if ($year < 1970) {
            throw new \Exception("L'année $year n'est pas valide.");
        }
        $this->month = $month;
        $this->year = $year;
    }
    /**
     * return first day of month
     *
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime
    {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }
    /**
     * returns month in letters
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }
    /**
     * See php dateTime doumentation for
     * more informations about dates methods
     * @return integer
     */
    public function getWeeks(): int
    {
        // get first day of month
        $start = $this->getStartingDay();
        // get last day of month thanks to modify method
        $end = (clone $start)->modify('+1 month -1 day');
        // return number of weeks in the month using format method
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        // need condition otherwise, when january comes, you might get a minus number of weeks
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }
/**
 * is the day in current month ?
 * @param \DateTime $date
 * @return boolean
 */
    public function withinMonth(\DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * to navigate to next month
     * @return Month
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;

        // If we are currently in december,
        // next month MUST be january
        // and year MUST increase of one
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * to navigate to previous month
     * @return Month
     */
    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;

        //If we are currently in january,
        // previous month MUST be december
        // and year MUST decrease of one
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
