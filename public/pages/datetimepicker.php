<?php 
    include_once("../php-assets/class.date.php");

    $b1 = new Date();

    if(!empty($_POST))
    {
        try 
        {   
            $b1->Date = $_POST['date'];
            $b1->TimeStart = $_POST['timestart'];
            $b1->TimeEnd = $_POST['timeend'];

            $b1->Save();

            $succes = "Thank you for registering a date!";

        }
        catch(Exception $e)
        {
            $error = $e->getMessage();
        }
    }
    
?><html>
<head>
    <title>Date and time picker</title>        
    <link href="../../resources/scss/calendarpicker.css" rel="stylesheet" type="text/css">
    <link href="../../resources/scss/timepicker.css" rel="stylesheet" type="text/css">        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="../../resources/js/timepicker.js" type="text/javascript"></script> 
    <script src="../../resources/js/calendarpicker.js" type="text/javascript"></script>        
    <script type="text/javascript">            
        function init() 
        {               
            calendar.set("date");

            $(document).ready(function(){
                $('input.timepicker').timepicker({timeFormat: 'HH:mm:ss', minTime: '15:30:00', maxTime: '21:00:00',scrollbar: true, interval: 15});
            });              
        }   

          
    </script>    
</head>
<body onload="init()">
    <form action="" method="post">            
        
        <label for="date">Datum</label>
        <input id="date" name="date" type="text">
        <br/>
        <label for="timestart">Start Uur</label>
        <input id="timepicker" name="timestart" class="timepicker" type="text">
        <br/>
        <label for="timeend">Eind Uur</label>
        <input id="timepicker" name="timeend" class="timepicker" type="text">
        <br/>
        <input class="submit" type="submit" id="btnSubmit" value="Book date" />     
    </form>
</body>
</html>