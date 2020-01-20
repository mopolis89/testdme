<?
require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");
$start=intval($_POST["start"]);
$finish=intval($_POST["finish"]);
if($_POST["sort"]=="albAsc"):
$seemore=handbook::seeMoreUser($start,$finish);
endif;
if($_POST["sort"]=="albDesc"):
    $seemore=handbook::seeMoreUserDesc($start,$finish);
endif;

if($_POST["sort"]=="dateAsc"):
    $seemore=handbook::seeMoreUserAscDate($start,$finish);
endif;

if($_POST["sort"]=="dateDesc"):
    $seemore=handbook::seeMoreUserDescDate($start,$finish);
endif;

echo json_encode($seemore);
?>

