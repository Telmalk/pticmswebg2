<?php
    function getHeader(PDO $pdo, string $currentPage) {
        $data = getHeaderData($pdo);
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Ptis Cms</title>
            <link href="../public/boostrap/css/bootstrap.css" rel="stylesheet">
        </head>
        <body role="document">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">PETIT CMS<a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <?php
                                    foreach ($data as $value) {
                                        getNavLink($value, $currentPage);
                                    }
                                ?>
                            </ul>
                        </div>
            </nav>

        <?php
    }

    function getHeaderData(PDO $pdo) {
        $sql = "
            SELECT
                title,
                slug
            FROM
                page;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        errorHandler($stmt);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return $data;
    }

    function getNavLink(array $value, string $currentPage) {
        $classLink = "";
        if ($value['slug'] === $currentPage) {
            $classLink = "class=active";
        }

        ?>
        <li <?=$classLink?>>
            <a class="nav-link" href="<?=APP_URL?>?<?=APP_PARAM_PAGE?>=<?=$value['slug']?>"><?=$value['title']?></a>
        </li>
        <?php
    }
    function getPage(array $toto) {
        ?>
        <div class="container theme-showcase" role="main">
            <div class="jumbotron">
                <h1><?=$toto['title']?></h1>
                <p><?=$toto['description']?></p>
                <span class="label btn btn-<?=$toto['span-label']?>"><?=$toto['span-text']?></span>
            </div>
            <img class="img-thumbnail" alt="<?=$toto['img-alt']?>" src="../public/img/<?=$toto['img']?>" data-holder-rendered="true">
        </div>
        </div>
        <?php
    }

    function getData(PDO $pdo, string $currentPage) {
        $sql = "
            SELECT
                title,
                description,
                `span-text`,
                `span-label`,
                img,
                `img-alt`
            FROM
                page
            WHERE 
                slug = :slug;   
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":slug", $currentPage);
        $stmt->execute();
        errorHandler($stmt);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
         if (!$data) {
             return null;
         }
         return $data;
    }

    function getFooter() {
        ?>
        </body>
        </html>
        <?php
    }

    function errorHandler(PDOStatement $stmt) {
        if ($stmt->errorCode() !== '00000') {
            throw new PDOException($stmt->errorInfo()[2]);
        }
    }