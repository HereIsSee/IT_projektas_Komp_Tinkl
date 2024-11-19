<!DOCTYPE html>
<html lang="en">
<head>
    <title>Renginiu kalendorius</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="../../IT_darbas/assets/css/sidenavigation.css" rel="stylesheet" type="text/css">
  <link href="../../IT_darbas/assets/css/calendar.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    
  </style>
</head>
<body>
    <div class="container-fluid">
    <div class="row content">
        <?php
        $activePage = 'calendar';
        include 'sidebar.php';
        ?>
        
        <div class="col-sm-9 main-content">
        <div class="calendar-wrapper">
            <?=$calendar?>
        </div>
        </div>

    </div>
    </div>
</body>
</html>