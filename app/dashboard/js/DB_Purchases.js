const clickableCells = document.querySelectorAll('.clickable'); //đây là các thẻ ở vị trí ô cột 1
const table_CTHD = document.getElementById("orderTable"); //lấy ra thẻ div hiện lên bảng chi tiết hóa đơn
const form_CTHD = document.getElementById("overlay"); //lấy ra thẻ div hiện lên bảng chi tiết hóa đơn
const button_X = document.getElementById("button_close");

const id_cus = document.querySelector('#id_cus');
const name_cus = document.querySelector('#name_cus');
const name_user = document.querySelector('#name_user');
const num_cus = document.querySelector('#num_cus');
const inner_show_purchase_detail = document.querySelector('#inner_show_purchase_detail');
const main_search = document.querySelector('#main_search');

function searchMain() {
  window.location.href = `./DB_Purchases.php?action=search_purchase&value_search=${main_search.value}`;
}

// Lấy URL hiện tại
const currentUrl = new URL(window.location.href);

// Lấy giá trị của tham số 'value_search'
if (currentUrl.searchParams.get("value_search")) {
  main_search.value = currentUrl.searchParams.get("value_search");
  main_search.focus();
}


const debounceSearchRealMain = debounceSearch(searchMain, 500);


main_search.addEventListener('input', debounceSearchRealMain);



async function getAllProductDetailPurchase(purchase_id) {

  const url = '../api/PurchaseAPI.php';
  const data = {
    action: 'get_all_purchase_detail_',
    purchase_id,
  };

  const response = await fetch(url, {
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
      inner_show_purchase_detail.innerHTML = data.map((element, index) => {
        return `
        <tr>
          <td>${index}</td>
          <td>${element[0]}</td>
          <td>${element[1]}</td>
          <td>${element[2]}</td>
          <td>${element[3]}</td>
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


  const result = await response;

  return result;
}



clickableCells.forEach(function (cell) {
  cell.addEventListener('click', function () {

    id_cus.innerHTML = cell.parentNode.children[0].textContent;
    name_cus.innerHTML = cell.parentNode.children[1].textContent;
    name_user.innerHTML = cell.parentNode.children[2].textContent;
    num_cus.innerHTML = cell.parentNode.children[5].textContent;

    form_CTHD.style.display = "flex";

    getAllProductDetailPurchase(cell.parentNode.children[0].textContent);

  });
});

button_X.addEventListener("click", function () {
  // Thực hiện hành động khi button được nhấn
  form_CTHD.style.display = 'none';
});


const button_add_purchase = document.getElementById("button_add_form_purchase");
//JS FORM OVERLAY 2

const button_X_2 = document.getElementById("button_close2");
const form_add_purchase_1 = document.getElementById("overlay2");
button_add_purchase.addEventListener("click", function () {

  form_add_purchase_1.style.display = 'flex';
});
button_X_2.addEventListener("click", function () {
  // Thực hiện hành động khi button được nhấn
  form_add_purchase_1.style.display = 'none';
});



//JS FORM OVERLAY 3
const button_list_pd = document.getElementById("btn_chon_sp");

const button_X_3 = document.getElementById("button_close3");
const form_add_purchase_2 = document.getElementById("overlay3");

const cb_pd = document.querySelectorAll('#overlay3 .wrapper_table #orderTable .cb_choose_pd');



button_list_pd.addEventListener("click", function () {
  form_add_purchase_2.style.display = 'flex';
});
button_X_3.addEventListener("click", function () {
  form_add_purchase_2.style.display = 'none';
});


let Array_product_import = [];// this is array list about id_product if we choose import


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

const inputSearch = document.querySelector('#search_name_pd');


const innerDetail = document.querySelector('#inner_select_detail');
const innerPurchase = document.querySelector('#inner_purchase_detail');

function renderInnerPurchase(Array_product_import) {
  innerPurchase.innerHTML = Array_product_import.map((element, index) => {

    return `
          <tr>
            <td>${index}</td>
            <td>${element.product_purchase_id}</td>
            <td>${element.name}</td>
            <td>${element.color}</td>
            <td>${element.size}</td>
            <td>${element.qty}</td>
            <td>${element.price}</td>
            <td>${element.priceReal}</td>
        </tr>
    `;

  }).join("");
}

function handleCheckBox() {
  var check_box = document.querySelectorAll('#overlay3 .wrapper_table #orderTable tbody tr .cb_choose_pd');

  for (var i = 0; i < check_box.length; i++) {

    check_box[i].addEventListener('click', function () {

      if (this.checked == true) {
        let gia_nhap, so_luong_nhap;

        try {

          do {
            gia_nhap = prompt("Vui lòng nhập giá nhập hàng !!");
            if (isNaN(gia_nhap) || gia_nhap === "") {
              throw new Error("Giá nhập phải là một số !");
            }
          } while (isNaN(gia_nhap) || gia_nhap === "");

          this.parentNode.parentNode.children[5].innerHTML = gia_nhap;

          do {

            so_luong_nhap = prompt("Vui lòng nhập số lượng nhập !!");
            if (isNaN(so_luong_nhap) || so_luong_nhap === "") {
              throw new Error("Số lượng nhập phải là một số !");
            }
          } while (isNaN(so_luong_nhap) || so_luong_nhap === "");

          this.parentNode.parentNode.children[6].innerHTML = so_luong_nhap;
        } catch (error) {
          alert(error.message);
        }

        if (gia_nhap == null || so_luong_nhap == null || (gia_nhap == null && so_luong_nhap == null)) {
          this.checked = false;
        }
        else {
          Array_product_import.push({
            qty: so_luong_nhap, price: gia_nhap, product_purchase_id: this.parentNode.parentNode.children[1].innerHTML, color: this.parentNode.parentNode.children[3].innerHTML,
            size: this.parentNode.parentNode.children[4].innerHTML, name: this.parentNode.parentNode.children[2].innerHTML, priceReal: this.parentNode.parentNode.children[7].innerHTML
          });
          renderInnerPurchase(Array_product_import);


        }
      }
      else if (this.checked == false) {

        this.parentNode.parentNode.children[5].innerHTML = "";
        this.parentNode.parentNode.children[6].innerHTML = "";

        Array_product_import = Array_product_import.filter((element1) => {
          if (
            element1.product_purchase_id === this.parentNode.parentNode.children[1].innerHTML && element1.color === this.parentNode.parentNode.children[3].innerHTML && element1.size === this.parentNode.parentNode.children[4].innerHTML
          ) {
            return false;
          } else return true;
        })

        renderInnerPurchase(Array_product_import);

      }
    });
  }

}


async function updateQtyPurchase(product_id, color, size, qty) {

  const url = '../api/PurchaseAPI.php';
  const data = {
    action: 'update_purchase_detail',
    product_id,
    color,
    size,
    qty,
  };

  const response = await fetch(url, {
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
      console.log(data);
    })
    .catch(error => {
      console.log(error);
    });


  const result = await response;

  return result;
}

async function addPurchase(supplier_id, user_id) {

  const url = '../api/PurchaseAPI.php';
  const data = {
    action: 'add_purchase',
    supplier_id,
    user_id,
  };

  const response = await fetch(url, {
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
      Array_product_import.forEach(async (element) => {
        await addPurchaseDetail(data, element.product_purchase_id, element.qty, element.price, element.color, element.size);
      });
    })
    .catch(error => {
      console.log(error);
    });


  const result = await response;

  return result;
}


async function addPurchaseDetail(purchase_id, product_id, qty, price, color, size) {

  const url = '../api/PurchaseAPI.php';
  const data = {
    action: 'add_purchase_detail',
    purchase_id,
    product_id,
    qty,
    price,
    color,
    size,
  };

  const response = await fetch(url, {
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

    })
    .catch(error => {
      console.log(error);
    });


  const result = await response;

  return result;
}

const btn_save_purchase = document.querySelector("#btn_save_purchase");

function getAllProductPurchase() {

  const url = '../api/PurchaseAPI.php';
  const data = {
    action: 'get_all_product_detail_purchase'
  };

  fetch(url, {
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
    .then(listDetailPurchase => {

      innerDetail.innerHTML = listDetailPurchase.map((element, index) => {
        var check = false, qty, price;

        Array_product_import.find((element1) => {
          if (element1.product_purchase_id === element[0] && element1.color === element[2] && element1.size === element[3]) {
            check = true;
            qty = element1.qty;
            price = element1.price;
            return true;
          }
        });

        return `
                <tr>
                  <td><input class="cb_choose_pd" type="checkbox" ${check ? "checked" : ""}></td>
                  <td>${element[0]}</td>
                  <td>${element[1]}</td>
                  <td>${element[2]}</td>
                  <td>${element[3]}</td>
                  <td>${check ? qty : ""}</td>
                  <td>${check ? price : ""}</td>
                  <td>${element[4]} đ</td>
                </tr>
            `;
      }).join("");

      setTimeout(() => {
        handleCheckBox();
      })

      //search
      function search() {
        if (inputSearch.value.trim() !== "") {
          const newData = listDetailPurchase.filter((element) => {
            const keySearch = element[0];

            if (keySearch.toLowerCase().includes(inputSearch.value)) {
              return true;
            } else {
              return false;
            }
          })

          innerDetail.innerHTML = newData.map((element, index) => {
            var check = false, qty, price;

            Array_product_import.find((element1) => {
              if (element1.product_purchase_id === element[0] && element1.color === element[2] && element1.size === element[3]) {
                check = true;
                qty = element1.qty;
                price = element1.price;
                return true;
              }
            });

            return `
                    <tr>
                      <td><input class="cb_choose_pd" type="checkbox" ${check ? "checked" : ""}></td>
                      <td>${element[0]}</td>
                      <td>${element[1]}</td>
                      <td>${element[2]}</td>
                      <td>${element[3]}</td>
                      <td>${check ? qty : ""}</td>
                      <td>${check ? price : ""}</td>
                      <td>${element[4]} đ</td>
                    </tr>
                `;
          }).join("");

          setTimeout(() => {
            handleCheckBox();
          }, 100)
        } else {

          innerDetail.innerHTML = listDetailPurchase.map((element, index) => {
            var check = false, qty, price;

            Array_product_import.find((element1) => {
              if (element1.product_purchase_id === element[0] && element1.color === element[2] && element1.size === element[3]) {
                check = true;
                qty = element1.qty;
                price = element1.price;
                return true;
              }
            });

            return `
                    <tr>
                      <td><input class="cb_choose_pd" type="checkbox" ${check ? "checked" : ""}></td>
                      <td>${element[0]}</td>
                      <td>${element[1]}</td>
                      <td>${element[2]}</td>
                      <td>${element[3]}</td>
                      <td>${check ? qty : ""}</td>
                      <td>${check ? price : ""}</td>
                      <td>${element[4]} đ</td>
                    </tr>
                `;
          }).join("");

          setTimeout(() => {
            handleCheckBox();
          }, 100)
        }
      }

      const debounceSearchReal = debounceSearch(search, 500);


      inputSearch.addEventListener('input', debounceSearchReal);


    })
    .catch(error => {
      console.log(error);
    });
}

getAllProductPurchase()

btn_save_purchase.onclick = () => {
  const supplier_id = document.querySelector('#name_stocker').value;
  const user_id = document.querySelector('#num_staff').textContent.trim().split(' - ')[0];
  if (supplier_id === 'none') {
    alert("Bạn chưa chọn nhà cung cấp!");
  } else
    addPurchase(supplier_id, user_id).then(() => {
      Array_product_import.forEach(async (element) => {
        await updateQtyPurchase(element.product_purchase_id, element.color, element.size, element.qty,);
      });
    }).then(() => {
      alert("Nhập phiếu nhập và chi tiết phiếu nhập thành công!")
      window.location.reload();
    });
}


setTimeout(() => {
  const sortID = document.querySelector('.col-1 .fa-sort');
  const sortPurchase = document.querySelector('.col-4 .fa-sort');

  console.log(sortID);

  sortID.onclick = () => {
    if (currentUrl.searchParams.get("action") === "sort_id_asc") {
      window.location.href = `./DB_Purchases.php?action=sort_id_desc`;
    } else if (currentUrl.searchParams.get("action") === "sort_id_desc") {
      window.location.href = `./DB_Purchases.php?action=sort_id_asc`;
    } else {
      window.location.href = `./DB_Purchases.php?action=sort_id_desc`;
    }
  }

  sortPurchase.onclick = () => {
    if (currentUrl.searchParams.get("action") === "sort_price_asc") {
      window.location.href = `./DB_Purchases.php?action=sort_price_desc`;
    } else if (currentUrl.searchParams.get("action") === "sort_price_desc") {
      window.location.href = `./DB_Purchases.php?action=sort_price_asc`;
    } else {
      window.location.href = `./DB_Purchases.php?action=sort_price_desc`;
    }
  }
})