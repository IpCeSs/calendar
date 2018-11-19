<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://bootswatch.com/4/sketchy/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css"></link>
    <title>When do we meet ?</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/">Friends Calendar</a>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Calendrier</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">chat</a>
      </li>

    </ul>
  </div>
</nav>
<?php
require '../src/Date/Month.php';
$month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start :$month->getStartingDay()->modify('last monday');
?>
<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
<h1><?=$month->toString();?></h1>
<div>
    <a href="/index.php?month=<?=$month->previousMonth()->month;?>&year=<?=$month->previousMonth()->year;?>" 
    class="btn btn-outline-primary">&lt;</a>
    <a href="/index.php?month=<?=$month->nextMonth()->month;?>&year=<?=$month->nextMonth()->year;?>" 
    class="btn btn-outline-primary">&gt;</a>
</div>

</div>
<table class="calendar__table calendar__table--<?=$month->getWeeks();?>weeks">
    <?php for ($i = 0; $i < $month->getWeeks(); $i++) : ?>
        <tr>
            <?php foreach ($month->days as $k => $day) : $date = (clone $start)->modify("+" . ($k + $i * 7) . "days") ?>
                    <td class="<?=$month->withinMonth($date) ? '' : 'calendar__othermonth';?>">
                    
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"> <?=$day;?></div>
                        <?php endif;?>
                <div class="calendar__day"> <?=$date->format('d');?></div>
            </td>
            <?php endforeach;?>
        </tr>
    <?php endfor;?>
</table>



</body>
</html>
