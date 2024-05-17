const modalStocker = document.querySelector("#add-stocker-modal");
const modalContent = document.querySelector(".modal-content");
const modalClose = document.querySelector("#add-stocker-modal .modal-close");
const addStocketButton = document.querySelector(".fixed-icon");
const submitStocketButton = document.querySelector(".submit");
const inputsModal = document.querySelectorAll("#add-stocker-modal input");

function openModal() {
  modalStocker.classList.add("open");
  for (const input of inputsModal) {
    input.required = true;
  }
}

function closeModal() {
  modalStocker.classList.remove("open");
  for (const input of inputsModal) {
    input.removeAttribute("required");
  }
}

addStocketButton.addEventListener("click", openModal);

modalClose.addEventListener("click", closeModal);

modalContent.addEventListener("click", function (event) {
  event.stopPropagation();
});



//bat su kien khi click vào ô mã ncc thì hiện ra chi tiêt ncc
const clickableCells = document.querySelectorAll('.clickable'); //đây là các thẻ ở vị trí ô cột 1
const show_supplier = document.getElementById("show-stocker-modal"); //lấy ra thẻ div hiện lên bảng chi tiết hóa đơn
const btn_close_edit_supplier = document.querySelector('#show-stocker-modal #button_close');



var mancc_edit;
var tenncc_edit;
var email_edit;
var sdt_edit;
var diachi_edit;



clickableCells.forEach(function (cell) {
  cell.addEventListener('click', function () {
    //hien cai bang thong tin nha cung cap
    show_supplier.classList.add("open");
    //lay cac gia trị trong bang gan vao bien
    var mancc = cell.parentElement.getElementsByTagName("td")[0].textContent;
    var tenncc = cell.parentElement.getElementsByTagName("td")[1].textContent;
    var email = cell.parentElement.getElementsByTagName("td")[2].textContent;
    var sdt = cell.parentElement.getElementsByTagName("td")[3].textContent;
    var diachi = cell.parentElement.getElementsByTagName("td")[4].textContent;
    //lay ra cac input de gan gia tri vao
    const form_show = document.getElementById('form_show_detai');
    const input_in_form_show = form_show.querySelectorAll("input");
    //thuc hien gan gia trị
    input_in_form_show[0].value = mancc;
    input_in_form_show[1].value = tenncc;
    input_in_form_show[2].value = email;
    input_in_form_show[3].value = sdt;
    input_in_form_show[4].value = diachi;

    //get ra buttom summit
    const btn_send = document.getElementById('btn_edit_supplier');
    btn_send.addEventListener("click", function () {
      send_submit(input_in_form_show);
    });
  });
});

function send_submit(input_in_form_show) {

  //get value of input after edit
  mancc_edit = input_in_form_show[0].value;
  tenncc_edit = input_in_form_show[1].value;
  email_edit = input_in_form_show[2].value;
  sdt_edit = input_in_form_show[3].value;
  diachi_edit = input_in_form_show[4].value;
  console.log(diachi_edit + "  " + email_edit);
  window.location.href = `./DB_Supplier.php?action=update_supplier&id=${mancc_edit}&ten=${tenncc_edit}&email=${email_edit}&diachi=${diachi_edit}&sdt=${sdt_edit}`;
}

btn_close_edit_supplier.addEventListener('click', function () {
  show_supplier.classList.remove('open')

})


//--------SEARCH----------
const btn_sort_active = document.getElementById("btn_sort_active");



function sort_active() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("table_suppliers");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.getElementsByTagName("tr");
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;

      x = rows[i].querySelector("#trangthai").value;
      y = rows[i + 1].querySelector("#trangthai").value;
      if (x.toLowerCase() > y.toLowerCase()) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);//là chèn phần tử rows[i + 1] vào trước phần tử rows[i]
      switching = true;
    }
  }
}

btn_sort_active.addEventListener("click", sort_active);
//sort name in table
// const btn_sort_name = document.getElementById("btn_sort_name");
// function sort_name() {
//   var table = document.getElementById("table_suppliers");

//   var rows = Array.from(table.getElementsByTagName("tr"));
//   rows.shift(); // Remove the table header

//   rows.sort(function (row1, row2) {
//     var status1 = row1.cells[0].textContent;
//     var status2 = row2.cells[0].textContent;
//     if (status1 < status2) return -1;
//     if (status1 > status2) return 1;
//     return 0;
//   });

//   rows.forEach(function (row) {
//     table.tBodies[0].appendChild(row);
//   });
// }


//fwb
function sort_name() {
  var table = document.getElementById("table_suppliers");
  var rows = table.rows;
  var switching = true;
  var i, x, y, shouldSwitch;

  while (switching) {
    switching = false;
    for (i = 1; i < rows.length - 1; i++) {
      //i = 1 để bỏ rows header
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("td")[1];
      console.log(x);
      y = rows[i + 1].getElementsByTagName("td")[1];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        /* Kiểm tra xem giá trị ten khach haang của phần tử hiện tại có lớn hơn giá trị giới tính của phần tử kế tiếp hay không. 
        Nếu có, gán giá trị true cho biến shouldSwitch. */
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      //doi vi tri 2 hang khi phần tử hiện tại có lớn hơn giá trị giới tính của phần tử kế tiếp
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
btn_sort_name.addEventListener("click", sort_name);

//SEARCH NAME OR NUMBER
const input_find_name = document.getElementById("input_find_name");
const input_find_number = document.getElementById("input_find_number");

function search_to_column(n, input) { // N IS COLUMN WE WILL SEARCH, INPUT IS INPUT WHICH WE WANT SEARCH
  var filter, table, tr, td, i, txtValue;

  filter = input.value.toUpperCase();
  table = document.getElementById("table_suppliers");

  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    txtValue = td[n].innerText;

    if (txtValue.toUpperCase().indexOf(filter) > -1) {

      tr[i].style.display = "";

    } else {

      tr[i].style.display = "none";
    }
  }

}
//this is add event into 2 button 
input_find_name.addEventListener("input", function () {
  search_to_column(1, input_find_name);
});


input_find_number.addEventListener("input", function () {
  search_to_column(3, input_find_number);
});


//UPDATE ISACTIVE OF STAFF
var tbody = document.querySelector("tbody");
var rows = tbody.getElementsByTagName("tr");

for (var i = 0; i < rows.length; i++) {
  var mySelect = rows[i].querySelector("select");
  mySelect.addEventListener("change", function () {
    var row = this.parentNode.parentNode;
    var cells = row.getElementsByTagName("td");
    var manv = cells[0].innerHTML; //GET VALUE MA NHAN VIEN
    var active = cells[5].querySelector("select").value; //GET VALUE NEW ACTIVE
    console.log(manv + " " + active); //LOG RA CHO XEM NE
    //code bên trên chỉ là bắt sự kiện khi onchange thôi
    var trangthai;
    if (active == "hoatdong") {
      trangthai = 1;//true
    } else {
      trangthai = 0;//false
    }
    //cau lenh nay giup minh gui 1 action ten la"update_trangthai" va 2 he so: staff_id and value
    //qua ben DB_Staff.php, chung ta se goi no ra
    window.location.href = `./DB_Supplier.php?action=update_trangthai&supplier_id=${manv}&value=${trangthai}`;

  });
}