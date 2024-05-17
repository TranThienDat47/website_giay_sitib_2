const $ = document.querySelector.bind(document);
if ($(".slideshow-container")) {
  let slideIndex = 1;
  showSlides(slideIndex);

  function currentSlide(n) {
    showSlides((slideIndex = n));
  }

  function plusSlides(n) {
    showSlides((slideIndex += n));
  }

  function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
      slideIndex = 1;
    }
    if (n < 1) {
      slideIndex = slides.length;
    }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active-slide", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active-slide";
  }

  const dots = document.getElementsByClassName("dot");
  for (let i of dots) {
    i.onclick = function () {
      currentSlide(Number(i.getAttribute("slide_rank")));
    };
  }
  setInterval(() => {
    plusSlides(1);
  }, 5000);
}

//banner
import ImgAnimation from "../components/ImgAnimation/index.js";

const listBanner = [
  "https://file.hstatic.net/200000522597/file/2_510x275_b4821a2d66c04eb09a0403079c2fd5bb.jpg",
  "https://file.hstatic.net/200000522597/file/3_510x275_b304bdd7130d489c9330c9dc2cdaadc2.jpg",
  "https://file.hstatic.net/200000522597/file/4_510x275_63bbf2e07bbf4510bc673944c9ddf028.jpg",
];

const listMainBanner = [
  {
    img: "https://file.hstatic.net/1000230642/file/385x665_l_30bc4508f8bf4a5d92493189f5fd6988.jpg",
    class_Name: "new-img img1",
  },
  {
    img: "https://file.hstatic.net/1000230642/file/795x665_46ed484a6c70459aa3bb54d88f0a2abb.jpg",
    class_Name: "new-img img2",
  },
  {
    img: "https://file.hstatic.net/1000230642/file/385x665_r_eb1943175a3b408cb2a17f98f4733cd8.jpg",
    class_Name: "new-img img3",
  },
];

if ($(".ads-banner-block")) {
  $(".ads-banner-block").innerHTML = listBanner
    .map((element) => ImgAnimation(element))
    .join("");
}

if ($(".new-img-block")) {
  $(".new-img-block").innerHTML = listMainBanner
    .map(
      (element) => `
                     <a class="${element.class_Name}">
                        ${ImgAnimation(element.img)}
                     </a>
                     `
    )
    .join("");
}

import SlideInfinit from "../components/InfiniteSlide/index.js";

if ($(".text-slide")) {
  $(".text-slide").innerHTML = SlideInfinit(10);
}

if ($(".footer-banner")) {
  $(".footer-banner").innerHTML = ImgAnimation(
    "https://file.hstatic.net/200000522597/file/2_1920x750_8d8ae5ef81364f288889339c63147dbb.jpg"
  );
}





//xử lý dữ liệu
import Product from './productItem.js';

function reverse(s) {
  var temp = '';
  for (var i = s.length - 1; i >= 0; i--) temp += s[i];
  return temp;
}

function numberMoney(s) {
  const tempCharacters = reverse(s);

  let newCharecters = '',
    tempCount = 0;
  for (let i = 2; i < tempCharacters.length; i += 3) {
    newCharecters += tempCharacters.substring(i - 2, i + 1) + ',';
    tempCount++;
  }
  if (newCharecters.length - tempCount < tempCharacters.length) {
    newCharecters += tempCharacters.substring(
      newCharecters.length - tempCount,
      tempCharacters.length + 1,
    );
    tempCount = 0;
  }
  return reverse(newCharecters);
}

const btnMoreCollectionMan = document.querySelector('.man.collection-container .cta-btn');
const btnMoreCollectionWoman = document.querySelector('.woman.collection-container .cta-btn');

if (btnMoreCollectionMan) {
  btnMoreCollectionMan.innerHTML = `<a href="./collection.php?value=1&title=Nam">Còn nhiều lắm, xem thêm</a>
<div class="underline"></div>`;
}

if (btnMoreCollectionWoman) {
  btnMoreCollectionWoman.innerHTML = `<a href="./collection.php?value=2&title=Nữ">Còn nhiều lắm, xem thêm</a>
<div class="underline"></div>`;
}

//show product nam
import ListDragProc from '../components/ListDragProc/index.js';

var ListProduct;

const url = '../api/ProductAPI.php';

const data = {
  action: 'all_product_with_category',
  value: 1
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
  .then(data => {
    var list_product_id = [];
    var newData = data[0].concat(data[1]);
    newData = newData.filter(item => item !== undefined);

    ListProduct = newData.map((item, index) => {

      if (list_product_id.includes(item[0])) {
        return;
      } else {
        list_product_id.push(item[0]);

        var price = parseInt(item[3]);

        price = numberMoney(price.toString())[0] !== ','
          ? numberMoney(price.toString())
          : numberMoney(price.toString()).replace(',', '');

        const list_product_cur = newData.filter((item1) => {
          return item1[0] === item[0];
        })


        const list_size = list_product_cur.map((size) => {

          return size[12];
        })
        var list_color = list_product_cur.map((color) => color[13]);

        list_color = list_color.filter((itemColor, indexColor) => {
          return list_color.indexOf(itemColor) === indexColor;
        });

        var list_color_temp = [];


        var detail_cur = list_product_cur.map((itemDetail, indextemp) => {
          if (list_color_temp.includes(itemDetail[13])) {
            return;
          } else {
            list_color_temp.push(itemDetail[13]);

            const list_product_detail_cur = list_product_cur.filter((itemDetail2) => {
              return itemDetail2[13] === itemDetail[13];
            })

            var total_qty = 0;

            const list_size_qty = list_product_detail_cur.map((size) => {
              total_qty += parseInt(size[14]);
              return {
                size: size[12],
                qty: size[14]
              };
            });

            const listOther = [itemDetail[8] || '', itemDetail[9] || '', itemDetail[10] || '', itemDetail[11] || '']

            return {
              color: itemDetail[13],
              imgs: {
                firstImg: itemDetail[6] || '',
                secondeImg: itemDetail[7] || '',
                orthers: listOther,
              },
              qty: total_qty,
              detail: list_size_qty,
            };
          }
        });


        detail_cur = detail_cur.filter(item => item !== undefined);

        return {
          _id: item[0],
          name: item[1],
          description: item[2],
          price: price,
          qty: item[4],
          newProc: item[5],
          shoeTypes: { gender: item[16], type: item[15] },
          size: list_size,

          colors: {
            list: list_color,
            detail: detail_cur,
          },
        };
      }
    })


    ListProduct = ListProduct.filter(item => item !== undefined);

    //collection nam
    const collectionMan = $('#prdZone__man');
    if (collectionMan) {
      let tempCountMan = 0;
      collectionMan.innerHTML = ListProduct.slice(0, 15)
        .map((element) => {
          tempCountMan++;
          let tempNewPrice = Number(element.price.replaceAll(',', ''));

          tempNewPrice = tempNewPrice * (100 - Number(element.promotions));
          return `
                  <div class="prd-zone__item">
                     ${Product({
            _id: element._id,
            name: element.name,
            price: element.price,
            color: element.colors,
            sizes: element.size,
            promotional_price: numberMoney(tempNewPrice.toString()),
            promotion_percentage: element.promotions,
            news: element.newProc,
          })}
                  </div>
               `;
        })
        .join('');

      if (tempCountMan <= 15) {
        btnMoreCollectionMan.innerHTML = "";
      }

    }

    return ListProduct;
  }).then((listProductNam) => {
    const data_nu = {
      action: 'all_product_with_category',
      value: 2
    };

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data_nu)
    })
      .then(response => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error('Error:', response.statusText);
        }
      })
      .then(data => {
        var list_product_id = [];
        var newData = data[0].concat(data[1]);
        newData = newData.filter(item => item !== undefined);

        ListProduct = newData.map((item, index) => {

          if (list_product_id.includes(item[0])) {
            return;
          } else {
            list_product_id.push(item[0]);

            var price = parseInt(item[3]);

            price = numberMoney(price.toString())[0] !== ','
              ? numberMoney(price.toString())
              : numberMoney(price.toString()).replace(',', '');

            const list_product_cur = newData.filter((item1) => {
              return item1[0] === item[0];
            })


            const list_size = list_product_cur.map((size) => {

              return size[12];
            })
            var list_color = list_product_cur.map((color) => color[13]);

            list_color = list_color.filter((itemColor, indexColor) => {
              return list_color.indexOf(itemColor) === indexColor;
            });

            var list_color_temp = [];


            var detail_cur = list_product_cur.map((itemDetail, indextemp) => {
              if (list_color_temp.includes(itemDetail[13])) {
                return;
              } else {
                list_color_temp.push(itemDetail[13]);

                const list_product_detail_cur = list_product_cur.filter((itemDetail2) => {
                  return itemDetail2[13] === itemDetail[13];
                })

                var total_qty = 0;

                const list_size_qty = list_product_detail_cur.map((size) => {
                  total_qty += parseInt(size[14]);
                  return {
                    size: size[12],
                    qty: size[14]
                  };
                });

                const listOther = [itemDetail[8] || '', itemDetail[9] || '', itemDetail[10] || '', itemDetail[11] || '']

                return {
                  color: itemDetail[13],
                  imgs: {
                    firstImg: itemDetail[6] || '',
                    secondeImg: itemDetail[7] || '',
                    orthers: listOther,
                  },
                  qty: total_qty,
                  detail: list_size_qty,
                };
              }
            });


            detail_cur = detail_cur.filter(item => item !== undefined);

            return {
              _id: item[0],
              name: item[1],
              description: item[2],
              price: price,
              qty: item[4],
              newProc: item[5],
              shoeTypes: { gender: item[16], type: item[15] },
              size: list_size,

              colors: {
                list: list_color,
                detail: detail_cur,
              },
            };
          }
        })


        ListProduct = ListProduct.filter(item => item !== undefined);

        //collection nu
        const collectionWoman = $('#prdZone__woman');
        if (collectionWoman) {
          var tempCountWoman = 0;
          collectionWoman.innerHTML = ListProduct.slice(0, 15)
            .map((element) => {
              tempCountWoman++;
              let tempNewPrice = Number(element.price.replaceAll(',', ''));

              tempNewPrice = tempNewPrice * (100 - Number(element.promotions));
              return `
                     <div class="prd-zone__item">
                        ${Product({
                _id: element._id,
                name: element.name,
                price: element.price,
                color: element.colors,
                sizes: element.size,
                promotional_price: numberMoney(tempNewPrice.toString()),
                promotion_percentage: element.promotions,
                news: element.newProc,
              })}
                     </div>
                  `;
            })
            .join('');
        }

        if (tempCountWoman <= 15) {
          btnMoreCollectionWoman.innerHTML = "";
        }

        const total_ListProduct = listProductNam.concat(ListProduct);
        //drag slide

        const wapperListRecom = $('.slider-product');
        if (wapperListRecom) {
          let dataRecommendProc = total_ListProduct.map((element) => {
            let tempNewPrice = Number(element.price.replaceAll(',', ''));

            tempNewPrice = tempNewPrice * (100 - Number(element.promotions));
            return Product({
              _id: element._id,
              name: element.name,
              price: element.price,
              color: element.colors,
              sizes: element.size,
              promotional_price: numberMoney(tempNewPrice.toString()),
              promotion_percentage: element.promotions,
              news: element.newProc,
            });
          });

          wapperListRecom.innerHTML = ListDragProc(1, dataRecommendProc);
        }

      })
      .catch(error => {
        console.error(error);
      });
  })
  .catch(error => {
    console.error(error);
  });





