/**
 * DBから予約データを取得
 */
async function fetchReservations(date) {
  if (!date) return [];
  try {
    const res = await fetch(`api/reservations/get.php?date=${date}`);
    const data = await res.json();
    return data;
  } catch (error) {
    console.error("エラー:", error);
    return [];
  }
}

/**
 * 部屋ごとにデータをグループ化
 */
function groupByRoom(data) {
  const grouped = {};

  data.forEach(r => {
    // 部屋がまだ登録されていなければ作成
    if (!grouped[r.room_id]) {
      grouped[r.room_id] = {
        room_name: r.room_name,
        reservations: []
      };
    }

    // 予約データ（user_nameなど）が存在する場合のみ配列に追加
    if (r.user_name) {
      grouped[r.room_id].reservations.push(r);
    }
  });

  return grouped;
}

/**
 * 時間文字列からインデックス（0-23）を取得
 */
function timeToIndex(datetime) {
  const time = datetime.split(' ')[1];
  const [h] = time.split(":").map(Number);
  return h;
}

/**
 * 24時間の空き状況配列を作成
 */
function createTimeline(reservations) {
  const slots = Array(24).fill(null);
  reservations.forEach(r => {
    const start = timeToIndex(r.start_datetime);
    const end = timeToIndex(r.end_datetime);
    for (let i = start; i < end; i++) {
      // slots[i] = r.user_name;
      slots[i] = r;
    }
  });
  return slots;
}

/**
 * モーダルを表示する  
 */
function showModal(roomName, reservation) {
  const modal = document.getElementById("reservationModal");

  // 情報を送る
  document.getElementById("modalRoomName").textContent = roomName;
  document.getElementById("modalUserName").textContent = reservation.user_name;
  document.getElementById("modalTitle").textContent = reservation.title;
  document.getElementById("modalTime").textContent = `
  ${reservation.start_datetime}～${reservation.end_datetime}
  `;
  // 表示
  modal.style.display = "block";

}


/**
 * 画面に描画するメイン処理
 */
function render(groupedData) {
  const app = document.getElementById('app');
  app.innerHTML = '';

  // 部屋ループ
  Object.values(groupedData).forEach(room => {
    const container = document.createElement('div');
    container.style.marginBottom = "20px";

    const title = document.createElement('h3');
    title.textContent = room.room_name;
    container.appendChild(title);

    const timeline = document.createElement('div');
    timeline.style.display = 'flex'; // 横並びを安定させる

    const slots = createTimeline(room.reservations);

    slots.forEach(s => {
      const div = document.createElement('div');
      div.style.width = '30px';
      div.style.height = '25px';
      div.style.marginRight = '2px';
      div.style.border = '1px solid #ddd';

      // 予約があれば青、なければグレー
      div.style.backgroundColor = s ? '#3498db' : '#e0e0e0';

      if (s) {
        div.title = s; // 予約者の名前をツールチップに
        div.style.backgroundColor = "#3498db";
        div.style.cursor = 'pointer';
        div.addEventListener("click", () => {
          showModal(room.room_name, s);
        })
      }

      timeline.appendChild(div);
    });

    container.appendChild(timeline);
    app.appendChild(container);
  });
}

/**
 *日付を受け取って「取得→描画」までを行う関数
 */
async function updateView(date) {
  const data = await fetchReservations(date);
  const grouped = groupByRoom(data);
  render(grouped);
}

// 予約モーダル開く
function openReserveModal() {
  const rModal = document.getElementById("reserveModal");
  // 表示
  rModal.style.display = "block";
}


// 予約情報をまとめる
function reserveInfo() {
  // 各要素取得
  const dayInfo = document.getElementById("inputDateReserve");
  const roomInfo = document.getElementById("selectRoom");
  const startTimeInfo = document.getElementById("startTime");
  const endTimeInfo = document.getElementById("endTime");
  const reserveDo = document.getElementById("reserveDo");
  // console.log(dayInfo, roomInfo, startTimeInfo, endTimeInfo);

  // クリック情報初期化
  let day = dayInfo.value;
  let room = roomInfo.value;
  let start = startTimeInfo.value;
  let end = endTimeInfo.value;
  // 各種情報を取得
  dayInfo.addEventListener("change", (e) => {
    day = e.target.value;
    // console.log(day);
  })

  roomInfo.addEventListener("change", (e) => {
    room = e.target.value;
    // console.log(room);
  })

  startTimeInfo.addEventListener("change", (e) => {
    start = e.target.value;
    // console.log(start);
  })

  endTimeInfo.addEventListener("change", (e) => {
    end = e.target.value;
    // console.log(end);
  })

  // 予約押したときの情報を取る
  reserveDo.addEventListener("click", async() => {
    const data = {
      date: day,
      room_id: room,
      start_time: start,
      end_time: end
    }
    console.log(data);
    try{
      const response= await fetch("api/reservations/create.php",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(data)
      });
      const result=await response.json()

    }catch(error){

    }
  })


}



/**
 * 初期化処理
 */
function init() {
  const iD = document.getElementById("inputDate");
  const modal = document.getElementById("reservationModal");
  const closeModal = document.getElementById("closeModal");

  // 1. 日付が変更されたら updateView を呼ぶように設定
  iD.addEventListener("change", (e) => {
    updateView(e.target.value);
  });

  // 2. ページを開いた瞬間、現在の入力値で一度実行する
  if (iD.value) {
    updateView(iD.value);
  }

  // モーダル閉じる
  closeModal.addEventListener("click", () => {
    modal.style.display = "none"
  })

  // 予約モーダル開く＆閉じる
  // 開く
  const reserveOpen = document.getElementById("reserveOpen");
  reserveOpen.addEventListener("click", () => {
    openReserveModal();
  })
  // 閉じる
  const closeReserve = document.getElementById("closeReserve");
  const reserveModal = document.getElementById("reserveModal");
  closeReserve.addEventListener("click", () => {
    reserveModal.style.display = "none"
  })


  reserveInfo();
}


// 実行！
init();

