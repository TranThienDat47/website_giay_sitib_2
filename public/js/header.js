const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);


const actionCart = $('.header__action-cart .header__action-item-text');
const actionUser = $('.header__action-account .header__action-item-text');

const wrapperActionUser = $(
   '.header__action-account .header__action-dropdown .header__action-dropdown_content',
);



const headerActionCart = $('.header__action-cart');
const headerActionUser = $('.header__action-account');


const checkNode = (parent, children) => {
   let node = children.parentNode;
   while (node !== null) {
      if (node === parent)
         return true;
      node = node.parentNode;
   }
   return false;
};




window.onclick = function (e) {
   if (actionCart.classList.contains('show-triangle')) {
      if (!checkNode(headerActionCart, e.target)) {
         actionCart.classList.remove('show-triangle');
         document.body.removeEventListener('wheel', preventScroll, { passive: false });
      }
   }

   if (actionUser.classList.contains('show-triangle')) {
      if (!checkNode(headerActionUser, e.target)) {
         actionUser.classList.remove('show-triangle');
         document.body.removeEventListener('wheel', preventScroll, { passive: false });
      }
   }
};

const preventScroll = (e) => {
   e.preventDefault();
   e.stopPropagation();
};

const scroll = (e) => {
   e.stopPropagation();

   return true;
};

actionCart.onclick = () => {
   actionCart.classList.toggle('show-triangle');

   if (actionCart.classList.contains('show-triangle')) {
      document.body.addEventListener('wheel', preventScroll, { passive: false });
      $('.cart-view-scroll').addEventListener('wheel', scroll);
   } else {
      document.body.removeEventListener('wheel', preventScroll, { passive: false });
      $('.cart-view-scroll').removeEventListener('wheel', scroll, { passive: true });
   }

   if (actionUser.classList.contains('show-triangle')) {
      actionUser.classList.remove('show-triangle');
   }
};

actionUser.onclick = () => {
   actionUser.classList.toggle('show-triangle');

   if (actionUser.classList.contains('show-triangle')) {
      document.body.addEventListener('wheel', preventScroll, { passive: false });
   } else {
      document.body.removeEventListener('wheel', preventScroll, { passive: false });
   }

   if (actionCart.classList.contains('show-triangle')) {
      actionCart.classList.remove('show-triangle');
   }
};


//User
const inputUser = $$('.form__field.form__field--text');
for (let i = 0; i < inputUser.length; i++) {
   inputUser[i].onblur = () => {
      if (inputUser[i].value.length > 0) {
         inputUser[i].parentNode.children[1].style.transform = 'translateY(-5px) scale(0.8)';
      } else {
         inputUser[i].parentNode.children[1].style.transform = 'scale(1)';
      }
   };

   inputUser[i].onfocus = () => {
      if (inputUser[i].value.length <= 0) {
         inputUser[i].parentNode.children[1].style.transform = 'translateY(-5px) scale(0.8)';
      }
   };
}

//Header top bar
const topbar = $('.header__topbar');
const header = $('.header');
const headerMain = $('.header__main');

const heightTopbar = topbar.getBoundingClientRect().height;
const heightHeader = header.getBoundingClientRect().height;

let tempScroll = 0;
window.onscroll = function () {
   if (document.body.style.overflow !== 'hidden') {
      let curScroll = window.scrollY;
      if (curScroll <= heightHeader) {
         header.classList.remove('scroll-show');
         header.classList.remove('scroll-show-translate');
         header.style.visibility = `visible`;
         header.style.transform = `translateY(${-curScroll}px)`;

         headerMain.style.boxShadow = 'none';
         headerMain.style.transform = `translateY(0)`;
         headerMain.style.boxShadow = 'none';

         topbar.style.transform = 'translateY(0)';
      } else if (curScroll < tempScroll) {
         header.style.transform = `translateY(${-heightTopbar}px)`;
         header.classList.add('scroll-show-translate');
         header.style.visibility = `visible`;

         headerMain.style.transform = `translateY(-1px)`;
         headerMain.style.boxShadow = '0 0 10px rgb(0 0 0 / 20%)';
      } else if (curScroll > heightHeader) {

         header.classList.add('scroll-show');
         header.style.visibility = `hidden`;
         headerMain.style.transform = `translateY(calc(-100% - ${heightTopbar}px))`;
         headerMain.style.boxShadow = 'none';
         topbar.style.transform = 'translateY(calc(-100% - 1px))';
      }
      tempScroll = curScroll;
   }
};

window.onload = () => {
   //Product
   const productSwatch = $$('.product-swatch-loop .swatch-loop-item');
   const firstImg = $$('.prod-img.first-image picture img');
   const secondeImg = $$('.prod-img.second-image picture img');

   for (let i = 0; i < productSwatch.length; i++) {
      const lengthChildren = productSwatch[i].children.length;
      for (let j = 0; j < lengthChildren; j++) {
         productSwatch[i].children[j].onclick = (e) => {
            e.stopPropagation();
            e.preventDefault();
            productSwatch[i].children[j].classList.toggle('active');
            for (let k = 0; k < lengthChildren; k++) {
               if (j != k) productSwatch[i].children[k].classList.remove('active');
            }
            firstImg[i].src = productSwatch[i].children[j].getAttribute('data-img-first');
            secondeImg[i].src = productSwatch[i].children[j].getAttribute('data-img-second');
         };
      }
   }
};




//search
function SearchItem({ href = '', img = '', title = '', price = '' }) {
   return `
        <a href="${href}" class="search-results__item-ult">
            <div class="search-results__thumbs">
                    <img alt="${title}"
                        src="${img}"
                        onerror="this.onerror=null;this.src='../../access/img/error-image-generic.png';"
                     >
            </div>
            <div class="search-results_title">
                <p title="${title}" >${title}</p>
                <p class="f-initial">${price} ₫</p>
            </div>
        </a>
        `;
}

function SearchResults(data = []) {
   let bottomSearch = '';

   if (data.length > 4) {
      bottomSearch = `
                    <div class="search-results__more">
                        <a href="./search.php">Xem thêm
                            ${data.length - 4} sản phẩm</a>
                    </div>
                  `;
   } else if (data.length <= 0) {
      bottomSearch = `
                    <p class="search-results-dataEmpty">Không có sản phẩm nào...</p>
                  `;
   }

   console.log(data);

   const searchItems = data
      .slice(0, 4)
      .map((element) => {
         if (element.colors.detail[0])
            return SearchItem({
               href: `./product.php?id=${element._id}`,
               img: element.colors.detail[0].imgs.firstImg,
               title: element.name,
               price: element.price,
            });
         else
            return SearchItem({
               href: `./product.php?id=${element._id}`,
               img: '',
               title: element.name,
               price: element.price,
            });
      })
      .join('');

   return `
    ${searchItems}
    ${bottomSearch}
    `;
}

const searhresult = $('.results-content');
const inputSearch = $('.input-search');

const checkNode1 = (parent, children) => {
   let node = children;
   while (node !== null) {
      if (node === parent) return true;
      node = node.parentNode;
   }
   return false;
};



let dataSearchResult = [];
let searchValue = '';


function findAll(lisproduct, value) {
   return lisproduct.filter(
      (item) =>
         item._id.toString().toLowerCase().search(value.toString().toLowerCase()) >= 0 ||
         item.name.toString().toLowerCase().search(value.toString().toLowerCase()) >= 0,
   );
}


const formSearch = $('.searchform-categoris');



document.onclick = (e) => {
   if (!checkNode1(inputSearch, e.target)) {
      searhresult.style.display = 'none';
   }
};

document.onscroll = (e) => {
   inputSearch.blur();
   searhresult.style.display = 'none';
};


//xử lý dữ liệu
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

var ListProduct;

const url = '../api/ProductAPI.php';
const data = {
   action: 'all_product_customer'
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



      //seach
      inputSearch.onclick = () => {
         setTimeout(() => {
            searchValue = inputSearch.value;
            if (searchValue.trim().length > 0) {
               dataSearchResult = findAll(ListProduct, searchValue.trim());
               searhresult.innerHTML = SearchResults(dataSearchResult);
               searhresult.style.display = 'block';
               if ($('.search-results__more>a'))
                  $('.search-results__more>a').href = `./search.php?value=${searchValue.trim()}`;
            } else {
               searhresult.style.display = 'none';
            }
         }, 0);
      };

      inputSearch.onkeydown = () => {
         setTimeout(() => {
            searchValue = inputSearch.value;
            formSearch.action = `./search.php?value=${searchValue.trim()}`;
            if (searchValue.trim().length > 0) {
               dataSearchResult = findAll(ListProduct, searchValue.trim());
               searhresult.innerHTML = SearchResults(dataSearchResult);
               searhresult.style.display = 'block';
               if ($('.search-results__more>a'))
                  $('.search-results__more>a').href = `./search.php?value=${searchValue.trim()}`;
            } else {
               searhresult.style.display = 'none';
            }
         }, 0);
      };


   })
   .catch(error => {
      console.error(error);
   });




//scroll to top
const btnToTop = $('#bttop.has-item');
if (btnToTop) {
   let toTop = false,
      tempScrollToTop = -1;
   const t = 6;

   const handWindow = () => {
      tempScrollToTop = window.scrollY;
      toTop = true;
      let q = window.scrollY,
         v = q / t;
      window.scrollTo(0, q - v);
   };

   btnToTop.onclick = handWindow;

   const vlue_Show_Scroll = (document.body.scrollHeight * 1) / 8;

   const handleScroll = () => {
      let flag = false;
      window.scrollY >= vlue_Show_Scroll ? (flag = true) : (flag = false);
      flag ? btnToTop.classList.add('open') : btnToTop.classList.remove('open');
      if (toTop) {
         let q = window.scrollY,
            v = q / t;
         if (q > tempScrollToTop) toTop = false;
         window.scrollTo(0, q - v);
         tempScrollToTop = window.scrollY;
         if (tempScrollToTop <= 0) toTop = false;
      }
   };

   window.addEventListener('scroll', handleScroll);
}
