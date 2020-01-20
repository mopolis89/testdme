<?
require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");
$start=intval($_POST["start"]);
$finish=intval($_POST["finish"]);
if($_POST["sort"]=="albAsc"):
    $seemore=handbook::getUserMain();
endif;
if($_POST["sort"]=="albDesc"):
    $seemore=handbook::getUserMainDesc();
endif;

if($_POST["sort"]=="dateAsc"):
    $seemore=handbook::getUserMainAscDate();
endif;

if($_POST["sort"]=="dateDesc"):
    $seemore=handbook::getUserMainDescDate();
endif;

echo json_encode($seemore);
?>
