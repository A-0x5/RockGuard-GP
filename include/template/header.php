<?php
    use function RockGuard\include\function\getTitle;
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title> <?php getTitle($page_title) ?> </title>
            <link rel = 'stylesheet' href =<?php  echo $css . 'bootstrap.min.css' ; ?> />
            <link rel = 'stylesheet' href ='<?php echo $css . "nprogress.css"; ?>' />
            <link rel = 'stylesheet' href ='<?php echo $css . "all.css"; ?>' />
            <link rel = 'stylesheet' href ='<?php echo $css . "main.css"; ?>' />
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway&display=swap">
        </head>
        <body>
 