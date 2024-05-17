//UPDATE ISACTIVE OF STAFF
var tbody = document.querySelector("#table_user #bodylistCustomer");
console.log(tbody);
var rows = tbody.getElementsByTagName("tr");
console.log(rows);
//--------SORT----------
const btn_sort_active = document.getElementById("btn_sort_active");
const btn_sort_name = document.getElementById("btn_sort_name");
const btn_sort_gender = document.getElementById("btn_sort_gender");

//sắp xếp theo hoạt động
function sort_active() {
  var table, rows, switching, i, x, y, swap;
  table = document.getElementById("table_user");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length - 1; i++) {
      //i = 1 để bỏ rows header
      swap = false;
      x = rows[i].querySelector("#trangthai").value;
      y = rows[i + 1].querySelector("#trangthai").value;
      if (x.toUpperCase() > y.toUpperCase()) {
        swap = true;
        break;
      }
    }
    if (swap) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
btn_sort_active.addEventListener("click", sort_active);

//sort name in table
// function sort_name() {
//   var table = document.getElementById("table_user");
//   var rows = Array.from(table.getElementsByTagName("tr"));
//   rows.shift(); // Remove the table header

//   rows.sort(function (row1, row2) {
//     var status1 = row1.cells[1].textContent;
//     var status2 = row2.cells[1].textContent;
//     if (status1 < status2) return -1;
//     if (status1 > status2) return 1;
//     return 0;
//   });

//   rows.forEach(function (row) {
//     table.tBodies[0].appendChild(row);
//   });
// }

//Sắp xếp theo tên
function sort_name() {
  var table = document.getElementById("table_user");
  var rows = table.rows;
  var switching = true;
  var i, x, y, swap;

  while (switching) {
    switching = false;
    for (i = 1; i < rows.length - 1; i++) {
      //i = 1 để bỏ rows header
      swap = false;
      x = rows[i].getElementsByTagName("td")[1];
      console.log(x);
      y = rows[i + 1].getElementsByTagName("td")[1];
      if (x.innerText.toUpperCase() > y.innerText.toUpperCase()) {
        /* Kiểm tra xem giá trị ten khach haang của phần tử hiện tại có lớn hơn giá trị giới tính của phần tử kế tiếp hay không. 
        Nếu lớn hơn, gán giá trị true cho biến swap. */
        swap = true;
        break;
      }
    }
    if (swap) {
      //doi vi tri 2 hang khi phần tử hiện tại có lớn hơn giá trị giới tính của phần tử kế tiếp
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
btn_sort_name.addEventListener("click", sort_name);

//Sắp xếp theo giới tính
function sort_gender() {
  var table = document.getElementById("table_user");
  var rows = table.rows;
  var switching = true;
  var i, x, y, swap;

  while (switching) {
    switching = false;
    for (i = 1; i < rows.length - 1; i++) {
      //i = 1 để bỏ rows header
      swap = false;
      x = rows[i].getElementsByTagName("td")[4];
      console.log(x);
      y = rows[i + 1].getElementsByTagName("td")[4];
      if (x.innerText.toUpperCase() > y.innerText.toUpperCase()) {
        /* Kiểm tra xem giá trị giới tính của phần tử hiện tại có lớn hơn giá trị giới tính của phần tử kế tiếp hay không. 
        Nếu có, gán giá trị true cho biến swap. */
        swap = true;
        break;
      }
    }
    if (swap) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
btn_sort_gender.addEventListener("click", sort_gender);

//TIM KIEM THEO TEN VA SDT
const input_find_name = document.getElementById("input_find_name");
const input_find_phone = document.getElementById("input_find_phone");

//Tim kiem theo ten
function searchName(n, input) {
  // n la cot muon tim kiem, input la input tim kiem ten
  var searchValue, table, tr, td, i, txtValue;

  searchValue = input.value.toUpperCase();
  table = document.getElementById("table_user");

  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    txtValue = td[n].innerText;

    if (txtValue.toUpperCase().indexOf(searchValue) > -1) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}

//Tim kiem theo sdt
function searchPhoneNum(n, input) {
  // n la cot muon tim kiem, input la input tim kiemso dien thoai
  var searchValue, table, tr, td, i, txtValue;

  searchValue = input.value;
  table = document.getElementById("table_user");

  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    txtValue = td[n].innerText;

    if (txtValue.indexOf(searchValue) == 0) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}

//Them su kien cho 2 input tim kiem
input_find_name.addEventListener("input", function () {
  searchName(1, input_find_name);
});

input_find_phone.addEventListener("input", function () {
  searchPhoneNum(3, input_find_phone);
});

// Change Trang Thai
for (var i = 0; i < rows.length; i++) {
  var mySelect = rows[i].querySelector("select");
  mySelect.addEventListener("change", function () {
    var row = this.parentNode.parentNode;
    var cells = row.getElementsByTagName("td");
    var manv = cells[0].innerHTML; //GET VALUE MA NHAN VIEN
    var active = cells[6].querySelector("select").value; //GET VALUE NEW ACTIVE
    console.log(manv + " " + active);
    //code bên trên chỉ là bắt sự kiện khi onchange thôi
    var trangthai;
    if (active == "hoatdong") {
      trangthai = 1; //true
    } else {
      trangthai = 0; //false
    }
    //cau lenh nay giup minh gui 1 action ten la"update_trangthai" va 2 he so: staff_id and value
    //qua ben DB_Staff.php, chung ta se goi no ra
    window.location.href = `./DB_User.php?action=update_trangthai&user_id=${manv}&value=${trangthai}`;
  });
}
