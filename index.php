<?php


?>
<?php include __DIR__ . "/template/header.php"; ?>

<main>
    <div id="app"></div>

    <div class="calender">
        <div>
            <label for="inputDate">日付を選択してください</label>
            <input type="date" name="inputDate" id="inputDate" value="<?php echo date('Y-m-d'); ?>" />
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
    <div>
        <button id="reserveOpen" class="btn btn-warning">予約する</button>
    </div>

    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>予約詳細</h2>
            <p><strong>部屋名:</strong><span id="modalRoomName"></span></p>
            <p><strong>予約者:</strong><span id="modalUserName"></span></p>
            <p><strong>件名:</strong><span id="modalTitle"></span></p>
            <p><strong>時間:</strong><span id="modalTime"></span></p>
            <button id="closeModal" class="btn btn-primary">閉じる</button>
        </div>
    </div>

    <div id="reserveModal" class="modal">
        <div class="modal-content">
            <div id="room" class="d-block mx-auto mb-3">
                <label for="selectRoom">会議室を選択してください</label>
                <select name="selectRoom" id="selectRoom">
                    <!-- <option value="" disabled selected hidden>選択してください</option> -->
                    <option class="roomNum" value="1">会議室1</option>
                    <option class="roomNum" value="2">会議室2</option>
                    <option class="roomNum" value="3">会議室3</option>
                </select>
            </div>

            <div id="selectDay" class="d-block mx-auto mb-3">
                <label for="inputDate">日付を選択してください</label>
                <input type="date" name="inputDateReserve" id="inputDateReserve" value="<?php echo date('Y-m-d'); ?>" />
            </div>
            <div id="selectTime" class="d-block mx-auto mb-5">
                <div>
                    <label for="startTime" class="me-3">開始時間</label>
                    <select name="startTime" id="startTime">
                        <!-- <option value="" disabled selected hidden>選択してください</option> -->
                        <option class="selectedStartTime" value="0:00">0:00</option>
                        <option class="selectedStartTime" value="1:00">1:00</option>
                        <option class="selectedStartTime" value="2:00">2:00</option>
                        <option class="selectedStartTime" value="3:00">3:00</option>
                        <option class="selectedStartTime" value="4:00">4:00</option>
                        <option class="selectedStartTime" value="5:00">5:00</option>
                        <option class="selectedStartTime" value="6:00">6:00</option>
                        <option class="selectedStartTime" value="7:00">7:00</option>
                        <option class="selectedStartTime" value="8:00">8:00</option>
                        <option class="selectedStartTime" value="9:00">9:00</option>
                        <option class="selectedStartTime" value="10:00">10:00</option>
                        <option class="selectedStartTime" value="11:00">11:00</option>
                        <option class="selectedStartTime" value="12:00">12:00</option>
                        <option class="selectedStartTime" value="13:00">13:00</option>
                        <option class="selectedStartTime" value="14:00">14:00</option>
                        <option class="selectedStartTime" value="15:00">15:00</option>
                        <option class="selectedStartTime" value="16:00">16:00</option>
                        <option class="selectedStartTime" value="17:00">17:00</option>
                        <option class="selectedStartTime" value="18:00">18:00</option>
                        <option class="selectedStartTime" value="19:00">19:00</option>
                        <option class="selectedStartTime" value="20:00">20:00</option>
                        <option class="selectedStartTime" value="21:00">21:00</option>
                        <option class="selectedStartTime" value="22:00">22:00</option>
                        <option class="selectedStartTime" value="23:00">23:00</option>
                    </select>
                </div>
                <div>
                    <label for="endTime" class="me-3">終了時間</label>
                    <select name="endTime" id="endTime">
                        <!-- <option value="" disabled selected hidden>選択してください</option> -->
                        <option class="selectedEndTime" value="0:00">0:00</option>
                        <option class="selectedEndTime" value="1:00">1:00</option>
                        <option class="selectedEndTime" value="2:00">2:00</option>
                        <option class="selectedEndTime" value="3:00">3:00</option>
                        <option class="selectedEndTime" value="4:00">4:00</option>
                        <option class="selectedEndTime" value="5:00">5:00</option>
                        <option class="selectedEndTime" value="6:00">6:00</option>
                        <option class="selectedEndTime" value="7:00">7:00</option>
                        <option class="selectedEndTime" value="8:00">8:00</option>
                        <option class="selectedEndTime" value="9:00">9:00</option>
                        <option class="selectedEndTime" value="10:00">10:00</option>
                        <option class="selectedEndTime" value="11:00">11:00</option>
                        <option class="selectedEndTime" value="12:00">12:00</option>
                        <option class="selectedEndTime" value="13:00">13:00</option>
                        <option class="selectedEndTime" value="14:00">14:00</option>
                        <option class="selectedEndTime" value="15:00">15:00</option>
                        <option class="selectedEndTime" value="16:00">16:00</option>
                        <option class="selectedEndTime" value="17:00">17:00</option>
                        <option class="selectedEndTime" value="18:00">18:00</option>
                        <option class="selectedEndTime" value="19:00">19:00</option>
                        <option class="selectedEndTime" value="20:00">20:00</option>
                        <option class="selectedEndTime" value="21:00">21:00</option>
                        <option class="selectedEndTime" value="22:00">22:00</option>
                        <option class="selectedEndTime" value="23:00">23:00</option>
                    </select>
                </div>

            </div>
            <div class="row">
                <button id="reserveDo" class="btn btn-warning btn-sm col-2 d-block mx-auto">予約</button>
                <button id="closeReserve" class="btn btn-danger btn-sm col-2 d-block mx-auto">閉じる</button>
            </div>

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

<?php include __DIR__ . "/template/footer.php"; ?>