<?php 
    require_once('Builder.php');
    $configPath = 'src' . DIRECTORY_SEPARATOR . 'config.json';
    $builder = new Builder($configPath);
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <title>Link Tree</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="src/button.css">
    <link rel="stylesheet"  href="src/index.css">
    <link rel="stylesheet" href="src/<? file_exists($builder->pathToButtonCss()) ? $builder->pathToButtonCss() : '' ?>">
    <link rel="stylesheet" href="src/font-awesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="src/font-awesome/css/solid.min.css">
    <link rel="stylesheet" href="src/font-awesome/css/brands.min.css">
</head>
<body>
    <main>
        <div class="profile-content">
        <?php
                $builder->renderHtmlHeader();
        ?>
        </div>
        <div class="link-tree" id="buttons_tree">
        <?php
                $builder->renderHtmlButton();                                
            ?>
        </div>
    </main>
</body>
            <?php
                $builder->renderHtmlFooter();                                                                         
            ?>
</html>