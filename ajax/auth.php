<?
require($_SERVER["DOCUMENT_ROOT"]."/core/class.php");
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
$login=(string)$_POST["email"];
$pass=md5((string)$_POST["pass"]);
$arrAuth=handbook::getAccess($login,$pass);
if(!empty($arrAuth))
{
    $answer=["error"=>"","data"=>$arrAuth[0]];
    $hash = md5(generateCode(10));
    setcookie("id", $arrAuth[0]['user_id'], time()+60*60*24*30, "/");
    setcookie("hash", $hash, time()+60*60*24*30, "/");
    handbook::hashSet($hash,intval($arrAuth[0]["user_id"]));
}
else
{
    $answer=["error"=>"Нет такого пользователя","data"=>""];
}

echo json_encode($answer);
