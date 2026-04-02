<?php


?>
<?php include __DIR__."/template/header.php"; ?>

<main>
<div id="app"></div>

<div class="calender">
     <div>
        <label for="inputDate">日付を選択してください</label>
        <input type="date" name="inputDate" id="inputDate" value="<?php echo date('Y-m-d'); ?>"/>
        <p>選択された日付: <span id="dateResult"></span></p>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputDate = document.querySelector("#inputDate");
        const dateResult = document.querySelector("#dateResult");

        // 初期値を表示
        dateResult.innerHTML = inputDate.value;

        // 日付変更時に表示を更新
        inputDate.addEventListener("change", (e) => {
          const value = e.target.value;
          dateResult.innerHTML = value;
        });
    });
    </script>
</div>

<div id="reservationModal" class="modal">
<div class="modal-content">
    <span class="close-buttton">&times;</span>
    <h2>予約詳細</h2>
    <p><strong>部屋名:</strong><span class="modalRoomName"></span></p>
    <p><strong>予約者:</strong><span class="modalUserName"></span></p>
    <p><strong>件名:</strong><span class="modalTitle"></span></p>
    <p><strong>時間:</strong><span class="modalTime"></span></p>
</div>

</div>

<!-- <div class="room-numbers">
    <div class="rooms">
        <h3>部屋名</h3>
        <ul class="d-flex flex-row">
            <li class="time-of-room-number● 0:00">0時</li>
            <li class="time-of-room-number● 1:00">1時</li>
            <li class="time-of-room-number● 2:00">2時</li>
            <li class="time-of-room-number● 3:00">3時</li>
            <li class="time-of-room-number● 4:00">4時</li>
            <li class="time-of-room-number● 5:00">5時</li>
            <li class="time-of-room-number● 6:00">6時</li>
            <li class="time-of-room-number● 7:00">7時</li>
            <li class="time-of-room-number● 8:00">8時</li>
            <li class="time-of-room-number● 9:00">9時</li>
            <li class="time-of-room-number● 10:00">10時</li>
            <li class="time-of-room-number● 11:00">11時</li>
            <li class="time-of-room-number● 12:00">12時</li>
            <li class="time-of-room-number● 13:00">13時</li>
            <li class="time-of-room-number● 14:00">14時</li>
            <li class="time-of-room-number● 15:00">15時</li>
            <li class="time-of-room-number● 16:00">16時</li>
            <li class="time-of-room-number● 17:00">17時</li>
            <li class="time-of-room-number● 18:00">18時</li>
            <li class="time-of-room-number● 19:00">19時</li>
            <li class="time-of-room-number● 20:00">20時</li>
            <li class="time-of-room-number● 21:00">21時</li>
            <li class="time-of-room-number● 22:00">22時</li>
            <li class="time-of-room-number● 23:00">23時</li>
        </ul>
    </div>
</div> -->

</main>

<?php include __DIR__."/template/footer.php"; ?>