<?php
header("Content-type:application/json; charset=utf-8");
require_once __DIR__ . "/../../config/functions.php";

$json = file_get_contents("php://input");
// file_put_contents("debug.txt", $json);
$data = json_decode($json, true);

// jsonで受け取ったデータを各変数化する
$date = $data["date"];
$room = $data["room_id"];
$start = $data["start_time"];
$end = $data["end_time"];


// 日付と時間を統合する（SQL準備）
$start_datetime = $date . " " . $start . ":00";
$end_datetime = $date . " " . $end . ":00";

// DBへ登録する
try {
    $db = db_connect();
    $sql = "INSERT INTO `reservations`
    (`user_id`, `room_id`, `start_datetime`, `end_datetime`, `title`, `memo`, `status`) VALUES 
    (:user_id, :room_id, :start_datetime, :end_datetime, :title, :memo, :status)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ":user_id"=>1,
        ":room_id"=>$room,
        ":start_datetime"=>$start_datetime,
        ":end_datetime"=>$end_datetime,
        ":title"=>"新規追加",
        ":memo"=>"成功！！",
        ":status"=>1
    ]);

    echo json_encode(["success"=>true]);

} catch (PDOException $e) {
    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
        ]);
}
