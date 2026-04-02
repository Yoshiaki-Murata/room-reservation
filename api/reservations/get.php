<?php
header("Content-type:application/json");
require_once __DIR__ . "/../../config/functions.php";

// 予約情報の取得
$date = $_GET["date"] ?? date("Y-m-d");
// DB呼び出し
    $db = db_connect();
try {
    $sql = "SELECT 
    r.id,
    r.room_id,
    rm.name AS room_name,
    u.name AS user_name,
    r.start_datetime,
    r.end_datetime,
    r.title
FROM reservations r
JOIN rooms rm ON r.room_id = rm.id
JOIN users u ON r.user_id = u.id
WHERE DATE(r.start_datetime) = :date
AND r.status = 1
ORDER BY r.room_id, r.start_datetime";

    $stmt = $db->prepare($sql);
    $stmt->execute([":date" => $date]);

    $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode([
        "error"=>$e->getMessage()
    ]);
}

