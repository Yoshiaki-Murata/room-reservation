async function fetchReservations(date) {
  try {
    const res = await fetch(`/room_reserve/api/reservations/get.php?date=${date}`);
    //./api/reservations/get.php?date=${date}
    // console.log(res);
    // const text=await res.text();
    // console.log(text)
    const data = await res.json();
    return data;
  } catch (error) {
    console.error("エラー:", error);
  }
}

function groupByRoom(data) {
  const grouped = {};

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

function timeToIndex(datetime) {
  const time = datetime.split(' ')[1];
  const [h, m] = time.split(":").map(Number);
  return h * 2 + (m >= 30 ? 1 : 0);
}

function createTimeline(reservations) {
  const slots = Array(48).fill(null);

  reservations.forEach(r => {
    const start = timeToIndex(r.start_datetime);
    const end = timeToIndex(r.end_datetime);

    for (let i = start; i < end; i++) {
      slots[i] = r.user_name;
    }
  });

  return slots;
}

function render(groupedData) {
  const app = document.getElementById('app');
  app.innerHTML = '';

  Object.values(groupedData).forEach(room => {
    const container = document.createElement('div');

    const title = document.createElement('h3');
    title.textContent = room.room_name;
    container.appendChild(title);

    const timeline = document.createElement('div');

    const slots = createTimeline(room.reservations);

    slots.forEach(s => {
      const div = document.createElement('div');
      div.style.display = 'inline-block';
      div.style.width = '12px';
      div.style.height = '20px';
      div.style.margin = '1px';
      div.style.backgroundColor = s ? 'blue' : 'lightgray';

      if (s) div.title = s;

      timeline.appendChild(div);
    });

    container.appendChild(timeline);
    app.appendChild(container);
  });
}

async function init() {
  const date = '2026-04-04';

  const data = await fetchReservations(date);
  console.log(data); // ← デバッグ

  const grouped = groupByRoom(data);
  render(grouped);
}

init();