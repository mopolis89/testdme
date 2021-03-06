<?
require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");
$page=explode("/",$_SERVER["REQUEST_URI"]);
if(count($page)>3) {
$idGetUser=$page[count($page)-2];
}
else
{
    $idGetUser=end($page);
}
$idGetUser=intval($idGetUser);
if(isset($_COOKIE["id"])):
    $idUser=$_COOKIE["id"];
else:
    $idUser=0;
endif;

$userData=[];
$userData=handbook::userData($idGetUser);
$hash=[];
$hash=handbook::hashGet($idUser);
if(isset($_COOKIE["hash"]) && $_COOKIE["hash"]==$hash[0]["hash_user"])
{?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Справочник</title>
    <!-- b0a8e2d8ccb04b24683d347076e80d29e451a385:d3aa2e6571e673001cb012eda23bd97d02234f0b -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Caption&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/solid.css"
          integrity="sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css"
          integrity="sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<link rel="stylesheet" href="/css/style.css"
<body>
<div class="container">
    <div class="users">
        <?foreach($userData as $key=>$user):?>
            <div class="row user mb-5">
                <div class="col-md-4 photosmall"><a data-fancybox="images" href="<?=$user["photo_medium"]?>"><img src="<?=$user["photo_large"]?>" alt=""></a></div>
                <div class="col-md-4 fio"><?=$user["fio"]?></div>
                <div class="col-md-4 data">
                    <div>Телефон: <?=$user["phone"]?></div>
                    <br>
                    <div>E-mail: <?=$user["email"]?></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
</body>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
<script src="/js/script.js"></script>
</html>
<?}
else
{
    echo "Вы не авторизованы! Пожалуйста <a href='/users/'>авторизуйтесь</a>.";
}

?>
