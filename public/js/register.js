var btn_res = document.getElementById("btn_res");
var tf_ho = document.getElementById("ho");
var tf_ten = document.getElementById("ten");
var rd_nu = document.getElementById("radio1");
var rd_nam = document.getElementById("radio2");
var tf_tk = document.getElementById("taikhoan");
var tf_mk = document.getElementById("matkhau");
var tf_sdt = document.getElementById("sdt");
var tf_diachi = document.getElementById("diachi");

//thẻ hiện chữ "đang kí thành công"
var label_correct = document.getElementsByClassName("correct");
var label_error = document.getElementsByClassName("errors");
var label_error_mail = document.getElementsByClassName("errors_mail");

//Show password
const btnHideShowPassword = document.getElementById("btnShowHidePassword");
btnHideShowPassword.onclick = function () {
  var x = document.getElementById("matkhau");
  if (x.type === "password") {
    btnHideShowPassword.classList.add("hidePassWord");
    btnHideShowPassword.classList.remove("showPassWord");
    x.type = "text";
  } else {
    btnHideShowPassword.classList.remove("hidePassWord");
    btnHideShowPassword.classList.add("showPassWord");
    x.type = "password";
  }
};

function account(tk, mk, sex, ho, ten, sdt, diachi) {
  // Hàm khởi tạo
  this.tk = tk; // this tham khảo đến đối tượng cần tạo
  this.mk = mk;
  this.sex = sex;
  this.ho = ho;
  this.ten = ten;
  this.sdt = sdt;
  this.diachi = diachi;
}

function check_res() {
  if (
    tf_ho.value == "" ||
    tf_ten.value == "" ||
    tf_tk.value == "" ||
    tf_mk.value == "" ||
    (rd_nam.checked == false && rd_nu.checked == false)
  ) {
    return false;
  } else {
    return true;
  }
}

function is_phonenumber() {
  var phonenumber = tf_sdt.value;
  var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
  if (phonenumber.match(phoneno)) {
    return true;
  } else {
    return false;
  }
}

function checkEmail() {
  var filter = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  if (!filter.test(tf_tk.value)) {
    return false;
  } else {
    return true;
  }
}

btn_res.onclick = () => {
  label_correct[0].style.display = "none";
  label_error[0].style.display = "none";
  label_error_mail[0].style.display = "none";

  var check = true;

  label_error[0].children[0].innerHTML = "Thông tin đăng kí không hợp lệ.";
  label_error_mail[0].children[0].innerHTML = "Email đã được sử dụng.";

  if (check_res() == false) {
    label_error[0].children[0].innerHTML = "Cần nhập đầy đủ thông tin trước khi đăng kí.";
    label_error[0].style.display = "block";
    document.querySelector(".content-center").scrollIntoView();

    check = false;
    return;
  }
  if (checkEmail() == false) {
    label_error_mail[0].children[0].innerHTML = "Email không hợp lệ!";
    label_error_mail[0].style.display = "block";
    document.querySelector("#field-gender").scrollIntoView();
    check = false;
    return;
  }
  if (is_phonenumber() == false) {
    label_error[0].children[0].innerHTML = "Số điện thoại không hợp lê.";
    label_error[0].style.display = "block";
    document.querySelector(".content-center").scrollIntoView();
    check = false;
  }
  if (check == true) {
    custommerRegister();
    // clear_tf();
  }




};

function clear_tf() {
  tf_ho.value = "";
  tf_ten.value = "";
  tf_tk.value = "";
  tf_mk.value = "";
  tf_diachi.value = "";
  tf_sdt.value = "";
  rd_nam.checked = false;
  rd_nu.checked = false;
}

//register
function custommerRegister() {

  var provinceElement = document.getElementById("province");
  var districtElement = document.getElementById("district");
  var villageElement = document.getElementById("ward");

  const url = '../api/CustommerAPI.php';
  const email = tf_tk.value;
  const password = tf_mk.value;
  const gender = rd_nam.checked ? "Nam" : "Nữ";
  const firstName = tf_ho.value;
  const lastName = tf_ten.value;
  const phone = tf_sdt.value;
  const address = tf_diachi.value;
  const province = provinceElement.value + "=" + provinceElement.options[provinceElement.selectedIndex].text;
  const district = districtElement.value + "=" + districtElement.options[districtElement.selectedIndex].text;
  const village = villageElement.value + "=" + villageElement.options[villageElement.selectedIndex].text;

  const data = {
    action: 'register',
    email: email,
    password: password,
    gender: gender,
    firstName: firstName,
    lastName: lastName,
    phone: phone,
    address: address,
    province: province,
    district: district,
    village: village,
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
      if (data[0] === true) {
        window.location.href = './login.php';
      } else {
        alert(
          'Đăng ký thất bại, bạn có thể thử đăng ký lại!'
        );
      }
    })
    .catch(error => {
      console.error(error);
    });
}

import ImgAnimation from "../components/ImgAnimation/index.js";

// const $ = document.querySelector.bind(document);

document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_4_eff4b4e0d3e5496790737063aefc92d5.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_1_fcccf4c902ec4c5dbffb267d55480361.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_2_eb3aab14e3c4460598b186581e14319c.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_3_4ea1528b7b6c4b768edca82c5177b63f.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_5_796788d0cc3c4cb8becdd4095b9657ec.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_6_cbc7d744bbad464393bbf3b378eb17e0.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_7_c8ce843f94c74e0e8e8aa51372ddf97b.jpg"
);
document.querySelector(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_8_bfbc1f9a56f24921979f053befbb7d67.jpg"
);

//Combobox tỉnh/huyện/xã
const host = "https://provinces.open-api.vn/api/";
var callAPI = async (api) => {
  return await axios.get(api).then((response) => {
    renderData(response.data, "province");
  });
};
callAPI("https://provinces.open-api.vn/api/?depth=1").then(() => {
});

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
