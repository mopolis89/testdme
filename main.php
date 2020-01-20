<?
require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");
?>
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
    <div class="row">
        <div class="col-md-3 mt-3 titlebox">Справочник</div>
        <div class="col-md-6 mt-3">
            <form id="search" action="">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Поиск по имени</span>
                </div>
                <input type="text" class="form-control search" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            </form>
            <?$users=[];
            if((!isset($_GET["alb"]) || $_GET["alb"]=="asc") && !isset($_GET["date"])):
            $users=handbook::getUserMain();
            endif;
            if($_GET["alb"]=="desc"):
            $users=handbook::getUserMainDesc();
            endif;
            if($_GET["date"]=="asc"):
            $users=handbook::getUserMainAscDate();
            endif;
            if($_GET["date"]=="desc"):
            $users=handbook::getUserMainDescDate();
            endif;
            ?>
            <div class="sorts mt-5 mb-5">
                <span>Сортировка:</span>
                <div class="row user">
                    <div data-sort="albAsc" class="col-md-3 sort <?if((!isset($_GET["alb"]) || $_GET["alb"]=="asc") && !isset($_GET["date"])):?>active<?endif?>">от A-Z</div>
                    <div data-sort="albDesc" class="col-md-3 sort  <?if($_GET["alb"]=="desc"):?>active<?endif?>">от Z-A</div>
                    <div data-sort="dateAsc" class="col-md-3 sort <?if($_GET["date"]=="asc"):?>active<?endif?>">дата по увелечению</div>
                    <div data-sort="dateDesc" class="col-md-3 sort <?if($_GET["date"]=="desc"):?>active<?endif?>">дата по уменьшению</div>
                </div>
            </div>
            <div class="users">
                <?foreach($users as $key=>$user):?>
                    <div class="row user mb-5">
                        <div class="col-md-4 photosmall"><img src="<?=$user["photo"]?>" alt=""></div>
                        <div class="col-md-4 fio"><a href="/users/<?=$user["id"]?>/"><?=$user["fio"]?></a></div>
                        <div class="col-md-4 date"><?=$user["birth"]?></div>
                    </div>
                <?endforeach;?>
            </div>
            <div class="seemore" <?if((!isset($_GET["alb"]) || $_GET["alb"]=="asc") && !isset($_GET["date"])):?>data-sort="albAsc"<?endif?> <?if($_GET["alb"]=="desc"):?>data-sort="albDesc"<?endif?> <?if($_GET["date"]=="asc"):?>data-sort="dateAsc"<?endif?> <?if($_GET["date"]=="desc"):?>data-sort="dateDesc"<?endif?>>Показать еще...</div>
        </div>
        <div class="col-md-3 mt-3">
            <div class="filterText">Фильтр по году рождения:</div>
            <ul class="boxfilter">
                <?$years=handbook::getYear();
                foreach($years as $key=>$year):?>
                    <li><a href="/filter/year/<?=$year["birth"]?>/"><?=$year["birth"]?></a></li>
                <?endforeach;?>
            </ul>
        </div>
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