//
const cb_address = document.getElementById("cb_adress");
const input_address = document.getElementById("new_address_user");
const phone_user = document.getElementById("phone_user");
const reception_name = document.getElementById("reception_name");

// const default_address = input_address.value
// cb_address.onchange = function () {
//   if (cb_address.value == "new") {
//     input_address.value = "";
//     input_address.placeholder = "Nhập địa chỉ mới";
//     input_address.removeAttribute("readonly");
//   } else if (cb_address.value == "default") {
//     input_address.value = default_address;
//     input_address.setAttribute("readonly", "false");
//   } else {
//     // console.log(cb_address.value);
//     input_address.value = cb_address.value;
//     input_address.setAttribute("readonly", "false");
//   }
// };

// var payment_btn = document.querySelector('.payment_finish_btn');
// var input_value_change = '';

// //Mảng lưu các option address mới
// newAddressOptions = [];
// newAddressValue = [];
// payment_btn.addEventListener('click', function () {
//   input_value_change = input_address.value;
//   //thêm option sau khi khách hàng chọn địa chỉ mới 
//   var option = document.createElement("option");
//   // option.value = "add";
//   option.text = input_value_change;
//   cb_address.appendChild(option)
//   newAddressOptions.push(option.outerHTML);
//   newAddressValue.push(input_address.value)
//   //Lưu trữ các option address đã được thêm vào phần tử select bằng localStorage
//   localStorage.setItem('newAddressOptions', JSON.stringify(newAddressOptions));
// })

// //Đặt lại các option address đã lưu trữ sau khi người dùng quay lại trang
// var storedOptions = JSON.parse(localStorage.getItem('newAddressOptions'));
// console.log(storedOptions);
// if(storedOptions) {
//   //thêm các option đã lưu trữ vào phần selec
//   for(i=0; i < storedOptions.length; i++) {
//     var option = document.createElement('option');
//     option.value = newAddressValue[i];
//     option.innerHTML = storedOptions[i];
//     cb_address.appendChild(option);
//   }
//   newAddressOptions = newAddressOptions.concat(storedOptions);
// }



//Combobox tỉnh/huyện/xã
const host = "https://provinces.open-api.vn/api/";
var callAPI = async (api) => {
  return await axios.get(api).then((response) => {
    renderData(response.data, "province");
  });
};
// callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {

//   // reloadAddress(6, 62, 1948);
// });

var callApiDistrict = async (api) => {
  return await axios.get(api).then((response) => {
    renderData(response.data.districts, "district");
  });
};
var callApiWard = async (api) => {
  return await axios.get(api).then((response) => {
    renderData(response.data.wards, "ward");
  });
};

var renderData = (array, select) => {
  let row = ' <option disable value="">chọn</option>';
  array.forEach((element) => {
    row += `<option value="${element.code}">${element.name}</option>`;
  });
  document.querySelector("#" + select).innerHTML = row;
};

$("#province").change(() => {
  callApiDistrict(host + "p/" + $("#province").val() + "?depth=2").then(() => {
    // printResult();
  });
});
$("#district").change(() => {
  callApiWard(host + "d/" + $("#district").val() + "?depth=2").then(() => {
    // printResult();
  });
});
$("#ward").change(() => {
  // printResult();
});

// var printResult = () => {
//   if (
//     $("#district").val() != "" &&
//     $("#province").val() != "" &&
//     $("#ward").val() != ""
//   ) {
//     let result =
//       $("#province option:selected").text() +
//       " | " +
//       $("#district option:selected").text() +
//       " | " +
//       $("#ward option:selected").text();
//     $("#result").text(result);
//   }
// };

const reloadAddress = (defaultProvinceCode, defaultDistrictCode, defaultWardCode) => {

  var selectDefaultOption = (selectId, value) => {
    $("#" + selectId).val(value);
  };

  var setDefaultAddress = () => {
    selectDefaultOption("province", defaultProvinceCode);
    callApiDistrict(host + "p/" + defaultProvinceCode + "?depth=2").then(() => {
      selectDefaultOption("district", defaultDistrictCode);
      callApiWard(host + "d/" + defaultDistrictCode + "?depth=2").then(() => {
        selectDefaultOption("ward", defaultWardCode);
        // printResult();
      });
    });
  };

  callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
    setDefaultAddress();
  });
}


//show default address 
function setDefaultAddress(default_address) {
  const province = parseInt(default_address[6].split("=")[0]);
  const district = parseInt(default_address[7].split("=")[0]);
  const ward = parseInt(default_address[8].split("=")[0]);

  reloadAddress(province, district, ward);
  input_address.value = default_address[5];
  phone_user.value = default_address[4];
  reception_name.value = default_address[2];
}

//payment method
var cbpayment = document.getElementById("cb_payment");
var paymentbox = document.getElementsByClassName("payment-container");

cbpayment.onchange = function () {
  if (cbpayment.value == "2") {
    paymentbox[0].classList.add("dis-block");
    paymentbox[1].classList.remove("dis-block");
  } else if (cbpayment.value == "3") {
    paymentbox[1].classList.add("dis-block");
    paymentbox[0].classList.remove("dis-block");
  } else {
    paymentbox[1].classList.remove("dis-block");
    paymentbox[0].classList.remove("dis-block");
  }
};

var default_address;

function renderAddressCompobox(array) {
  let row = '';
  row += '<option disable value="-1">Địa chỉ đã lưu</option>'
  array.forEach((element) => {

    if (parseInt(element[3]) !== 1) {
      row += `<option value="${element[0]}=-=${element[1]}=-=${element[2]}=-=${element[3]}=-=${element[4]}=-=${element[5]}=-=${element[6]}=-=${element[7]}=-=${element[8]}">${element[2]}, ${element[5]}, ${element[6].split("=")[1]}, ${element[7].split("=")[1]}, ${element[8].split("=")[1]}</option>`;
    } else {
      default_address = element;
      row += `<option value="${element[0]}=-=${element[1]}=-=${element[2]}=-=${element[3]}=-=${element[4]}=-=${element[5]}=-=${element[6]}=-=${element[7]}=-=${element[8]}" selected>${element[2]}, ${element[5]}, ${element[6].split("=")[1]}, ${element[7].split("=")[1]}, ${element[8].split("=")[1]} (default)</option>`;
    }
  });
  document.querySelector("#cb_adress").innerHTML = row;
};

//get all address
function custommerAddress() {
  const url = '../api/AddressCustomerAPI.php';

  const data = {
    action: 'get_all_address_customer'
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
        throw new Error('Error:', response
          .statusText);
      }
    })
    .then(data => {
      renderAddressCompobox(data);

      callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
        setDefaultAddress(default_address);
      });

    })
    .catch(error => {
      console.error(error);
    });
}

custommerAddress();

cb_address.onchange = (e) => {
  const data = e.target.value.split("=-=");
  setDefaultAddress(data);
}

const btn_Payment = document.querySelector('#btn_finish_payment');

btn_Payment.onclick = () => {
  if (cbpayment.value === "default") {
    alert("Bạn chưa chọn phương thức thanh toán, vui lòng chọn lại!");
    return;
  } else {
    custommerPayment();
  }
}


function custommerPayment() {
  const url = '../api/PaymentAPI.php';

  const provinceElement = document.getElementById("province");
  const districtElement = document.getElementById("district");
  const villageElement = document.getElementById("ward");

  const payment_method_id = cbpayment.value;
  const address_id = cb_address.value.split('=-=')[0];
  const address_name = reception_name.value;
  const address_phone = phone_user.value;
  const address_detail = input_address.value;
  const address_province = provinceElement.value + "=" + provinceElement.options[provinceElement.selectedIndex].text;
  const address_dictrict = districtElement.value + "=" + districtElement.options[districtElement.selectedIndex].text;
  const address_ward = villageElement.value + "=" + villageElement.options[villageElement.selectedIndex].text;


  const data = {
    action: 'payment_method_id',
    payment_method_id: payment_method_id,
    address_id: address_id,
    address_name: address_name,
    address_phone: address_phone,
    address_detail: address_detail,
    address_province: address_province,
    address_dictrict: address_dictrict,
    address_ward: address_ward,
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
        throw new Error('Error:', response
          .statusText);
      }
    })
    .then(data => {
      if (data) {
        alert("Bạn đã mua hàng thành công! Hãy tiếp tục mua hàng.")
        window.location.href = "./home.php";
      } else {
        alert("Thanh toán không hợp lệ!");
        window.location.href = "./cart.php";
      }
    })
    .catch(error => {
      console.error(error);
    });
}