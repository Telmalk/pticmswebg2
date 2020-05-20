<?php
     define("APP_ROOT_DIR", dirname(__DIR__)."/");
     define("APP_PARAM_PAGE", "page");
     define("APP_URL", "index.php");
     define("APP_DEFAULT_PAGE", "got");

     require_once APP_ROOT_DIR . "includes/function.php";
     require_once APP_ROOT_DIR . "includes/data.php";
     require_once APP_ROOT_DIR . "includes/connect.php";

     $currentPage = $_GET[APP_PARAM_PAGE] ?? APP_DEFAULT_PAGE;


     $dataPage = getData($pdo, $currentPage);
     if (is_null($dataPage)) {
        http_response_code(404);
        $currentPage = APP_DEFAULT_PAGE;
        $dataPage = getData($pdo, $currentPage);
     }
     getHeader($data, $currentPage);
     getPage($dataPage);
     getFooter();
