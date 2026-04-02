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
  if (!data || !Array.isArray(data)) return grouped;

  data.forEach(r => {
    if (!grouped[r.room_id]) {
      grouped[r.room_id] = {
        room_name: r.room_name,
        reservations: []
      };
    }
    grouped[r.room_id].reservations.push(r);
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
      slots[i] = r.user_name;
    }
  });
  return slots;
}

/**
 * 画面に描画するメイン処理
 */
function render(groupedData) {
  const app = document.getElementById('app');
  app.innerHTML = '';

  // データが空の場合のメッセージ
  if (Object.keys(groupedData).length === 0) {
    app.innerHTML = '<p>この日の予約はありません。</p>';
    return;
  }

  Object.values(groupedData).forEach(room => {
    const container = document.createElement('div');
    container.style.marginBottom = "20px";

    const title = document.createElement('h3');
    title.textContent = room.room_name;
    container.appendChild(title);

    const timeline = document.createElement('div');
    const slots = createTimeline(room.reservations);

    slots.forEach(s => {
      const div = document.createElement('div');
      div.style.display = 'inline-block';
      // 1時間あたりの幅を少し広めに設定（HTMLの目盛りと合わせるため）
      div.style.width = '30px'; 
      div.style.height = '25px';
      div.style.margin = '1px';
      div.style.border = '1px solid #ddd';
      div.style.backgroundColor = s ? '#3498db' : '#f0f0f0';

      if (s) div.title = s; // ホバーで名前表示

      timeline.appendChild(div);
    });

    container.appendChild(timeline);
    app.appendChild(container);
  });
}

/**
 * 【重要】日付を受け取って「取得→描画」までを行う関数
 */
async function updateView(date) {
  console.log("表示更新の日付:", date);
  const data = await fetchReservations(date);
  const grouped = groupByRoom(data);
  render(grouped);
}

/**
 * 初期化処理
 */
function init() {
  const iD = document.getElementById("inputDate");

  // 1. 日付が変更されたら updateView を呼ぶように設定
  iD.addEventListener("change", (e) => {
    updateView(e.target.value);
  });

  // 2. ページを開いた瞬間、現在の入力値で一度実行する
  if (iD.value) {
    updateView(iD.value);
  }
}

// 実行！
init();