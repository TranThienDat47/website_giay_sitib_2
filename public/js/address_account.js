const icon_action_edit = document.querySelectorAll('span.action_edit a');  //get icon edit addres
const form_edit_address = document.querySelectorAll('#address_tables .edit_address');

const form_show_address = document.querySelectorAll('#address_tables .show_infor_account');


const button_close_edit_address = document.querySelectorAll('.edit_address .action_bottom span a');
const button_close_address = document.querySelectorAll('#address_tables .row .address_title  .text-right .action_delete a');

const list_row_form_address = document.querySelectorAll('#address_tables .row');
const list_address_table_form_address = document.querySelectorAll('#address_tables .address_table');

const list_btn_update_address = document.querySelectorAll('#btn_update_address');


const reloadAddress = (defaultProvinceCode, defaultDistrictCode, defaultWardCode) => {
  const host = "https://provinces.open-api.vn/api/";

  var callAPI = async (api) => {
    return await axios.get(api).then((response) => {
      renderData(response.data, "province");
    });
  };
  var renderData = (array, select) => {
    let row = ' <option disable value="">chọn</option>';
    array.forEach((element) => {
      row += `<option value="${element.code}">${element.name}</option>`;
    });
    document.querySelector("#" + select).innerHTML = row;
  };

  var selectDefaultOption = (selectId, value) => {
    $("#" + selectId).val(value);
  };

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

function formEditAddress(address_id) {
  setTimeout(() => {
    const host = "https://provinces.open-api.vn/api/";

    var callAPI = async (api) => {
      return await axios.get(api).then((response) => {
        renderData(response.data, "province");
      });
    };

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
        const default_address = data.find((element) => (parseInt(address_id) === parseInt(element[0])))

        callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
          setDefaultAddress(default_address, address_id);

        });

      })
      .catch(error => {
        console.error(error);
      });
  }, 100)

  return `
    <form accept-charset="UTF-8" 
        id="address_form_${address_id}" method="post">
        <input name="form_type" type="hidden" value="customer_address">
        <input name="utf8" type="hidden" value="✓">

        <div class="input-group">
            <span class="input-ico"><i class="fa fa-user-o"></i></span>
            <input type="text" 
                class="input-textbox textbox" name="lastName" size="40"
                value="" placeholder="Họ">
        </div>
        <div class="input-group">
            <span class="input-ico"><i class="fa fa-user-o"></i></span>
            <input type="text" id="address_first_name_1125532830"
                class="input-textbox textbox" name="firstName" size="40"
                value="2" placeholder="Tên">
        </div>
        <div class="input-group">
            <span class="input-ico"><i class="fa fa-home"></i></span>
            <input type="text" name="detail"
                class="input-textbox textbox" size="40"
                value="" placeholder="Địa chỉ">
        </div>

        <div class="address">
            <div class="input-group" id="address_province_container_1125532830"
                style="">
                <div>
                    <span class="input-ico"><i class="fa fa-map-marker"></i></span>

                    <select id="province"
                        class="province-select input-textbox textbox"
                        name="province">
                        <option value="">--Chọn tỉnh/thành phố--</option>
                    </select>
                </div>
            </div>
            <div class="input-group" id="address_province_container_1125532830"
                style="">
                <div>
                    <span class="input-ico"><i class="fa fa-map-marker"></i></span>

                    <select id="district" class="input-textbox textbox"
                        name="district">
                        <option value="">--Chọn quận/huyện--</option>
                    </select>
                </div>
            </div>
            <div class="input-group" id="address_province_container_1125532830"
                style="">
                <div>
                    <span class="input-ico"><i class="fa fa-map-marker"></i></span>

                    <select class="input-textbox textbox" id="ward" name="ward">
                        <option value="">--Chọn phường/xã--</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="input-group" style="display:none">
            <span class="input-ico"><i class="fa fa-map-marker"></i></span>
            <input type="text" id="address_zip_1125532830"
                class="input-textbox textbox" name="address[zip]" size="40"
                value="">
        </div>
        <div class="input-group">
            <span class="input-ico"><i class="fa fa-phone"></i></span>
            <input type="text" id="address_phone_1125532830"
                class="input-textbox textbox" name="phone" size="40"
                value="" placeholder="Số điện thoại">
        </div>
        <div class="input-group">
            <input style = "margin-right: 12px;" type="checkbox" id="address_default_address"
                name="default_address" value="1"> <label for="address_default_address">Đặt làm địa chỉ mặc định.</label>
        </div>
    </form>
  `;
}


var previousBtnHuy = null;

//show default address 
function setDefaultAddress(default_address, address_id) {
  const province = parseInt(default_address[6].split("=")[0]);
  const district = parseInt(default_address[7].split("=")[0]);
  const ward = parseInt(default_address[8].split("=")[0]);

  const form_addres = document.getElementById(`address_form_${address_id}`);

  reloadAddress(province, district, ward);

  let nameArray = default_address[2].split(" ");
  let lastName = nameArray.slice(0, -1).join(" ");
  let firstName = nameArray.slice(-1).join(" ");

  form_addres.detail.value = default_address[5];
  form_addres.phone.value = default_address[4];
  form_addres.firstName.value = firstName;
  form_addres.lastName.value = lastName;
  form_addres.default_address.checked = default_address[3];
}

for (let i = 0; i < icon_action_edit.length; i++) {
  const button = icon_action_edit[i];
  button.onclick = function () {

    const form_edit_address_inner = document.querySelectorAll('#address_tables .edit_address #inner_edit_address');

    form_edit_address[i].style.display = "block";
    form_show_address[i].style.display = "none";


    if (previousBtnHuy !== null && button_close_edit_address[i].getAttribute('data-address_id') !== previousBtnHuy.getAttribute('data-address_id')) {
      previousBtnHuy.click();
    }

    previousBtnHuy = button_close_edit_address[i];

    setTimeout(() => {
      form_edit_address_inner[i].innerHTML = formEditAddress(button_close_edit_address[i].getAttribute('data-address_id'));
      // addressUpdate();

    });

  };
}



for (let i = 0; i < button_close_edit_address.length; i++) {
  const button = button_close_edit_address[i];
  button.onclick = function () {
    const form_edit_address_inner = document.querySelectorAll('#address_tables .edit_address #inner_edit_address');

    form_edit_address[i].style.display = "none";
    form_show_address[i].style.display = "block";
    form_edit_address_inner[i].innerHTML = "";
  };
}

for (let i = 0; i < list_btn_update_address.length; i++) {
  const button = list_btn_update_address[i];
  button.onclick = function () {
    // console.log(list_btn_update_address[i].getAttribute('data-address_id'));

    const form_addres = document.getElementById(`address_form_${button_close_edit_address[i].getAttribute('data-address_id')}`);

    const phone = form_addres.phone.value
    const firstName = form_addres.firstName.value
    const lastName = form_addres.lastName.value
    const detail = form_addres.detail.value
    const is_default = form_addres.default_address.checked;

    const provinceElement = document.getElementById("province");
    const districtElement = document.getElementById("district");
    const villageElement = document.getElementById("ward");


    const address_province = provinceElement.value + "=" + provinceElement.options[provinceElement.selectedIndex].text;
    const address_dictrict = districtElement.value + "=" + districtElement.options[districtElement.selectedIndex].text;
    const address_ward = villageElement.value + "=" + villageElement.options[villageElement.selectedIndex].text;

    const url = '../api/AddressCustomerAPI.php';


    const address_id = button_close_edit_address[i].getAttribute('data-address_id');
    const address_name = lastName + " " + firstName;
    const address_default = is_default;
    const address_phone = phone;
    const address_detail = detail;

    const data = {
      action: 'update_address_customer',
      address_id: address_id,
      address_name: address_name,
      address_default: address_default,
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
          alert("Cập nhật địa chỉ thành công!");
          window.location.reload();
        }
      })
      .catch(error => {
        console.error(error);
      });

  };
}


for (let i = 0; i < button_close_address.length; i++) {
  const button = button_close_address[i];
  button.onclick = function () {

    if (document.querySelectorAll('#address_tables .row .address_title  .text-right .action_delete a').length > 1) {
      if (confirm("Bạn có chắc chắc muốn xóa địa chỉ này không?")) {
        const url = '../api/AddressCustomerAPI.php';


        const address_id = button_close_edit_address[i].getAttribute('data-address_id');

        const data = {
          action: 'delete_address_customer',
          address_id: address_id
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
              alert("Xóa địa chỉ thành công!");
              window.location.reload();
            }
          })
          .catch(error => {
            console.error(error);
          });
      }

    } else {
      alert("Không thể xóa địa chỉ mặc định này!")
    }
  };
}


// add new address account
const btn_add_adderss = document.querySelectorAll('.wrap_addAddress .add-new-address');

const form_add_new_address = document.getElementById('add_address');

const btn_close_form_add_new_address = form_add_new_address.querySelectorAll('#address_form_new .action_bottom span a');


btn_add_adderss[0].addEventListener("click", function () {
  // Xử lý sự kiện click ở đây
  form_add_new_address.style.display = 'block';

});

btn_close_form_add_new_address[0].addEventListener("click", function () {
  // Xử lý sự kiện click ở đây
  form_add_new_address.style.display = 'none';

});


// function addressUpdate() {
//   //Combobox tỉnh/huyện/xã
//   const host = "https://provinces.open-api.vn/api/";
//   var callAPI = async (api) => {
//     return await axios.get(api).then((response) => {
//       renderData(response.data, "province");
//     });
//   };
//   callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
//     $("#province").change(() => {
//       callApiDistrict(host + "p/" + $("#province").val() + "?depth=2").then(() => {
//       });
//     });
//     $("#district").change(() => {
//       callApiWard(host + "d/" + $("#district").val() + "?depth=2").then(() => {
//       });
//     });
//   });

//   var callApiDistrict = async (api) => {
//     return await axios.get(api).then((response) => {
//       renderData(response.data.districts, "district");
//     });
//   };
//   var callApiWard = async (api) => {
//     return await axios.get(api).then((response) => {
//       renderData(response.data.wards, "ward");
//     });
//   };

//   var renderData = (array, select) => {
//     let row = ' <option disable value="">chọn</option>';
//     array.forEach((element) => {
//       row += `<option value="${element.code}">${element.name}</option>`;
//     });
//     document.querySelector("#" + select).innerHTML = row;
//   };


// }


function addressCreate() {
  //Combobox tỉnh/huyện/xã
  const host = "https://provinces.open-api.vn/api/";
  var callAPI = async (api) => {
    return await axios.get(api).then((response) => {
      renderData(response.data, "province1");
    });
  };
  callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
  });

  var callApiDistrict = async (api) => {
    return await axios.get(api).then((response) => {
      renderData(response.data.districts, "district1");
    });
  };
  var callApiWard = async (api) => {
    return await axios.get(api).then((response) => {
      renderData(response.data.wards, "ward1");
    });
  };

  var renderData = (array, select) => {
    let row = ' <option disable value="">chọn</option>';
    array.forEach((element) => {
      row += `<option value="${element.code}">${element.name}</option>`;
    });
    document.querySelector("#" + select).innerHTML = row;
  };

  $("#province1").change(() => {
    callApiDistrict(host + "p/" + $("#province1").val() + "?depth=2").then(() => {
      // printResult();
    });
  });
  $("#district1").change(() => {
    callApiWard(host + "d/" + $("#district1").val() + "?depth=2").then(() => {
      // printResult();
    });
  });
  $("#ward1").change(() => {
    // printResult();
  });

  // var printResult = () => {
  //   if (
  //     $("#district1").val() != "" &&
  //     $("#province1").val() != "" &&
  //     $("#ward1").val() != ""
  //   ) {
  //     let result =
  //       $("#province1 option:selected").text() +
  //       " | " +
  //       $("#district1 option:selected").text() +
  //       " | " +
  //       $("#ward1 option:selected").text();
  //     // $("#result1").text(result);
  //   }
  // };
}

addressCreate();


