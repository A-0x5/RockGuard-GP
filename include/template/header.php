<?php
    use function RockGuard\include\function\getTitle;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> <?php getTitle($page_title); ?> </title>
        
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
        <!-- NProgress CSS CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
        
        <!-- Font Awesome CSS CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        
        <!-- Main CSS  -->
        <link rel="stylesheet" href="<?php echo $css . 'main.css'; ?>">
        
        <link rel = 'stylesheet' href ='<?php echo $css . "nprogress.css"; ?>' />
        
        <!-- Google Fonts CDN -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway&display=swap">
    </head>
    <body>
