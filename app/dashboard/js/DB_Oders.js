const clickableCells = document.querySelectorAll('.clickable'); //đây là các thẻ ở vị trí ô cột 1
const table_CTHD = document.getElementById("orderTable"); //lấy ra thẻ div hiện lên bảng chi tiết hóa đơn
const form_CTHD = document.getElementById("overlay"); //lấy ra thẻ div hiện lên bảng chi tiết hóa đơn
const button_X = document.getElementById("button_close");
const trangthai = document.querySelectorAll(".list_trangthai");

const id_content = document.getElementById("id_content");
const name_content = document.getElementById("name_content");
const num_content = document.getElementById("num_content");
const address_content = document.getElementById("address_content");
const order_date_content = document.getElementById("order_date_content");
const ship_date_content = document.getElementById("ship_date_content");
const payment_method_content = document.getElementById("payment_method_content");
const tong_tien = document.getElementById("tong_tien");
const tong_so_luong = document.getElementById("tong_so_luong");
const inner_show_oder_detail = document.getElementById("inner_show_oder_detail");
const find_date_btn = document.getElementById("find_date_btn");
const date_begin = document.getElementById("date_begin");
const date_end = document.getElementById("date_end");

async function getAllProductDetailOrder(cart_id) {

  const url = '../api/OrderAPI.php';
  const data = {
    action: 'get_all_product_detail_order',
    cart_id,
  };

  await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Error:', response.statusText);
      }
    })
    .then(data => {
      inner_show_oder_detail.innerHTML = data.map((element, index) => {
        return `
          <tr>
              <td>${index}</td>
              <td>${element[1]} (${element[2]} / ${element[3]})</td>
              <td>${element[0]}</td>
              <td>${element[4]}</td>
              <td>${element[5]} đ</td>
              <td>${element[6]} đ</td>
          </tr>
        `;
      }).join('');
    })
    .catch(error => {
      console.log(error);
    });
}


clickableCells.forEach(function (cell) {
  cell.addEventListener('click', function () {

    form_CTHD.style.display = "flex";

    const id = cell.textContent;
    const name = cell.parentNode.children[2].getAttribute('data-name');
    const phone = cell.parentNode.children[2].textContent;
    const address = cell.parentNode.children[2].getAttribute('data-address');
    const order_date = cell.parentNode.children[4].textContent;
    const ship_date = cell.parentNode.children[5].textContent;
    const payment_method_day = cell.parentNode.children[2].getAttribute('data-payment');
    const tongTien = cell.parentNode.children[3].textContent;
    const so_luong = cell.parentNode.children[2].getAttribute('data-qty');


    tong_tien.textContent = tongTien;
    tong_so_luong.textContent = so_luong;
    id_content.textContent = id;
    name_content.textContent = name;
    num_content.textContent = phone;
    address_content.textContent = address;
    order_date_content.textContent = order_date;
    ship_date_content.textContent = ship_date;
    payment_method_content.textContent = payment_method_day;

    getAllProductDetailOrder(id);

  });
});

button_X.addEventListener("click", function () {
  // Thực hiện hành động khi button được nhấn
  form_CTHD.style.display = 'none';
});


// js calender

for (let i = 0; i < trangthai.length; i++) {
  trangthai[i].onchange = () => {
    const tempTrangThai = trangthai[i].selectedIndex;
    const tempText = prompt(`Nhập "${trangthai[i].value}" để đồng cập nhật trạng thái!`);
    if (tempText === trangthai[i].value) {
      const cart_id = trangthai[i].parentNode.parentNode.children[0].textContent;
      const new_status = trangthai[i].value;
      window.location.href = `./DB_Oders.php?action=update_status_cart&cart_id=${cart_id}&new_status=${new_status}`;
    } else if (tempText === null) {
      window.location.reload();
    } else {
      alert('Cập nhật trạng thái thất bại!');
    }
  }
}

const inputSearch = document.querySelector('#input_search_real');


// Lấy URL hiện tại
const currentUrl = new URL(window.location.href);

var temp_date_begin = false, temp_date_end = false;

// Lấy giá trị của tham số 'value_search'
if (currentUrl.searchParams.get("value_search")) {
  inputSearch.value = currentUrl.searchParams.get("value_search");
  inputSearch.focus();
} else if (currentUrl.searchParams.get("date_begin") && currentUrl.searchParams.get("date_end")) {
  date_begin.value = currentUrl.searchParams.get("date_begin").split(" ")[0];
  date_end.value = currentUrl.searchParams.get("date_end").split(" ")[0];
  temp_date_begin = date_begin.value;
  temp_date_end = date_end.value;
}




function debounceSearch(callback, delay) {
  let timerId;

  return function () {
    const context = this;
    const args = arguments;

    clearTimeout(timerId);

    timerId = setTimeout(() => {
      callback.apply(context, args);
    }, delay);
  }
}

function search() {
  if (inputSearch.value.trim() !== "") {
    window.location.href = `./DB_Oders.php?action=search_ordeer&value_search=${inputSearch.value.trim()}`;
  } else {
    window.location.href = `./DB_Oders.php`;
  }
}

const debounceSearchReal = debounceSearch(search, 500);

inputSearch.addEventListener('input', debounceSearchReal);

find_date_btn.onclick = () => {

  if (date_begin.value.trim() === "" || date_end.value.trim() === "") {
    if (temp_date_begin && temp_date_end) {
      window.location.href = `./DB_Oders.php`;
    } else {
      alert("Bạn phải chọn khoảng ngày giao hàng!")
    }
  } else {
    window.location.href = `./DB_Oders.php?action=search_date&date_begin=${date_begin.value.trim() + " 00:00:00"}&date_end=${date_end.value.trim() + " 23:59:59"}`;
  }
}

setTimeout(() => {
  const sortID = document.querySelector('.col-1 .fa-sort');
  const sortPurchase = document.querySelector('.col-4 .fa-sort');

  console.log(sortID);

  sortID.onclick = () => {
    if (currentUrl.searchParams.get("action") === "sort_id_asc") {
      window.location.href = `./DB_Oders.php?action=sort_id_desc`;
    } else if (currentUrl.searchParams.get("action") === "sort_id_desc") {
      window.location.href = `./DB_Oders.php?action=sort_id_asc`;
    } else {
      window.location.href = `./DB_Oders.php?action=sort_id_desc`;
    }
  }

  sortPurchase.onclick = () => {
    if (currentUrl.searchParams.get("action") === "sort_price_asc") {
      window.location.href = `./DB_Oders.php?action=sort_price_desc`;
    } else if (currentUrl.searchParams.get("action") === "sort_price_desc") {
      window.location.href = `./DB_Oders.php?action=sort_price_asc`;
    } else {
      window.location.href = `./DB_Oders.php?action=sort_price_desc`;
    }
  }
})