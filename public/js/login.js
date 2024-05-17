var login = document.getElementsByClassName("form_login");
//đây là form repâss
var re_pass = document.getElementsByClassName("recover_pass_form");
var erro_login = document.getElementsByClassName("errors");
//đây là nút khi ấn vào là gửi re pass
var active_re_pass = document.getElementsByClassName("btn_re_pas");
var tf_email_repass = document.querySelector(
  ".recover_pass_form #tf_email_repass"
);

var tk = document.getElementById("taikhoan");
var mk = document.getElementById("matkhau");

var btn_login = document.getElementById("dangnhap");
//đây là chữ khi ấn vào thì chuyển sang form re pass
var btn_re_pass = document.getElementById("req_pas");
var btn_cancer_re_pass = document.getElementById("cancer_repass");

document.querySelector("#showPassword").onclick = function () {
  var x = document.getElementById("matkhau");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
};

//CHƯA LÀM GÌ VỀ LOGIC

import ImgAnimation from "../components/ImgAnimation/index.js";

const $ = document.querySelector.bind(document);

$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_4_eff4b4e0d3e5496790737063aefc92d5.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_1_fcccf4c902ec4c5dbffb267d55480361.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_2_eb3aab14e3c4460598b186581e14319c.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_3_4ea1528b7b6c4b768edca82c5177b63f.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_5_796788d0cc3c4cb8becdd4095b9657ec.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_6_cbc7d744bbad464393bbf3b378eb17e0.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_7_c8ce843f94c74e0e8e8aa51372ddf97b.jpg"
);
$(".img_footer").innerHTML += ImgAnimation(
  "https://file.hstatic.net/200000522597/file/240x240_8_bfbc1f9a56f24921979f053befbb7d67.jpg"
);
