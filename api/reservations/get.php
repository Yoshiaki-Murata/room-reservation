<?php
header("Content-type:application/json; charset=utf-8");
require_once __DIR__ . "/../../config/functions.php";

$date = $_GET["date"] ?? date("Y-m-d");

try {
    $db = db_connect();
    
    // 全ての部屋(rooms)を左側に置き、予約データ(reservations)を紐づけます
    $sql = "SELECT 
                rm.id AS room_id,
                rm.name AS room_name,
                res_info.user_name,
                res_info.start_datetime,
                res_info.end_datetime,
                res_info.title
            FROM rooms rm
            LEFT JOIN (
                /* 予約データとユーザー名をあらかじめ結合したセットを作る */
                SELECT 
                    r.room_id, 
                    u.name AS user_name, 
                    r.start_datetime, 
                    r.end_datetime,
                    r.title
                FROM reservations r
                JOIN users u ON r.user_id = u.id
                WHERE DATE(r.start_datetime) = :date 
                AND r.status = 1
            ) res_info ON rm.id = res_info.room_id
            ORDER BY rm.id, res_info.start_datetime";

    $stmt = $db->prepare($sql);
    $stmt->execute([":date" => $date]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}