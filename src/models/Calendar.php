<?php
class Calendar {
    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null) {
        $this->set_date($date ?? date('Y-m-d'));
    }

    public function set_date($date) {
        $this->active_year = date('Y', strtotime($date));
        $this->active_month = date('m', strtotime($date));
        $this->active_day = date('d', strtotime($date));
    }

    public function add_event(Event $event) {
		$this->events[] = $event;
    }

    public function adjust_month($months) {
        $date = strtotime("{$this->active_year}-{$this->active_month}-01 + $months month");
        $this->set_date(date('Y-m-d', $date));
    }

    public function __toString() {
        $num_days = date('t', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_year . '-' . $this->active_month . '-01')));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-01')), $days);

        $html = '<div class="calendar">';
        
        $prev_month = $this->active_month - 1;
        $prev_year = $this->active_year;
        if ($prev_month < 1) {
            $prev_month = 12;
            $prev_year--;
        }

        $next_month = $this->active_month + 1;
        $next_year = $this->active_year;
        if ($next_month > 12) {
            $next_month = 1;
            $next_year++;
        }
        $html .= '<div class="header">';
        $html .= '<a href="?month=' . $prev_month . '&year=' . $prev_year . '" class="prev">&laquo; Previous</a>';
        $html .= '<div class="month-year">' . date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-01')) . '</div>';
        $html .= '<a href="?month=' . $next_month . '&year=' . $next_year . '" class="next">Next &raquo;</a>';
        $html .= '</div>';
        

        // Days of the week
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '<div class="day_name">' . $day . '</div>';
        }

        // Days from previous month
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '<div class="day_num ignore">' . ($num_days_last_month - $i + 1) . '</div>';
        }

        // Days in current month
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = ($i == $this->active_day) ? ' selected' : '';
            $html .= '<div class="day_num' . $selected . '"><span>' . $i . '</span>';
            
            // Check for events on each day
            foreach ($this->events as $event) {
                // Display the event if it falls on the current date
                if (date('Y-m-d', strtotime($event->getDate())) == date('Y-m-d', strtotime("{$this->active_year}-{$this->active_month}-$i"))) {
                    $html .= '<div class="event" style="background-color:' . htmlspecialchars("orange") . ';">';
                    $html .= '<a href="event_page.php?id=' . urlencode($event->getId()) . '" style="color: inherit; text-decoration: none;">';
					$html .= htmlspecialchars($event->getTitle());
					$html .= '</a>';
                    $html .= '</div>';
                }
            }
            $html .= '</div>';
        }

        // Filler days for next month
        for ($i = 1; $i <= (42 - $num_days - max($first_day_of_week, 0)); $i++) {
            $html .= '<div class="day_num ignore">' . $i . '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
?>
