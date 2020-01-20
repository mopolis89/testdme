<?require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");

$router = Router::fromGlobals();
// Add single rule with Closure handler.
$router->add('/', function () {
    include $_SERVER["DOCUMENT_ROOT"]."/main.php";
});

$router->add('/index.php', function () {
    include $_SERVER["DOCUMENT_ROOT"]."/main.php";
});

$router->add('/users/:num/' , function () {
        include $_SERVER["DOCUMENT_ROOT"]."/users/user.php";
    });
$router->add('/users/:num' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/users/user.php";
});
$router->add('/filter/' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/filter/index.php";
});
$router->add('/filter/year/:num' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/filter/filter.php";
});
$router->add('/filter/year/:num/' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/filter/filter.php";
});
$router->add('/filter/year/' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/filter/index.php";
});
$router->add('/filter/year' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/filter/index.php";
});
$router->add('/search/' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/search/index.php";
});
$router->add('/search' , function () {
    include $_SERVER["DOCUMENT_ROOT"]."/search/index.php";
});
// Start route processing
if ($router->isFound()) {
    $router->executeHandler(
        $router->getRequestHandler(),
        $router->getParams()
    );
}
else {
    // Simple "Not found" handler
    $router->executeHandler(function () {
        http_response_code(404);
        echo '404 Not found';
    });
}