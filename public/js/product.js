const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const shareLink = $('.sharing__link');

import Product from './productItem.js';

import ListDragProc from '../components/ListDragProc/index.js';

const checkNodePlus = (parent, children) => {
    let node = children.parentNode;
    while (node !== null) {
        if (node === parent) return true;
        node = node.parentNode;
    }
    return false;
};

function ColorOption(data, checked) {
    let tempColorOption;

    if (checked) {
        tempColorOption = `
       <div class="productDetail__swatch-element color den">
          <input
             class="productDetail__variant-0"
             type="radio" name="option1"
             value="${data.color}" data-vhandle="den" checked>
          <label class="productDetail__den productDetail__sd" class="productDetail__sd"
             for="swatch-0-den">
             <img src="${data.img}"
                   alt="Giày Thể Thao Nam Hunter Street Bloomin' Central DSMH08500DEN (${data.color})"
                   title="${data.color}"
                   onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                   >
             <span>${data.color}</span>
          </label>
       </div>            
       `;
    } else {
        tempColorOption = `
       <div class="productDetail__swatch-element color den">
          <input
             class="productDetail__variant-0"
             type="radio" name="option1"
             value="${data.color}" data-vhandle="den">
          <label class="productDetail__den " for="swatch-0-den">
             <img src="${data.img}"
                   alt="Giày Thể Thao Nam Hunter Street Bloomin' Central DSMH08500DEN (${data.color})"
                   title="${data.color}"
                   onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                   >
             <span>${data.color}</span>
          </label>
       </div>            
       `;
    }

    return tempColorOption;
}

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


const urlParams = new URLSearchParams(window
    .location.search);
const id = urlParams.get('id');

const url = '../api/ProductAPI.php';
const data = {
    action: 'one_product',
    productID: id
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

        var ListProduct = newData.map((item, index) => {

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

        return ListProduct.filter(item => item !== undefined);
    }).then((listProduct) => {

        const urlParams = new URLSearchParams(window.location.search);

        function find(listProduct, productID) {
            return listProduct.filter((item) => Number(item._id) === Number(productID));
        }

        //routing
        const checkVetify = find(listProduct, urlParams.get('id'));

        if (checkVetify.length <= 0) {
            if (confirm("Sản phẩm hết hàng hoặc không tồn tại!")) {
                window.location.href = './home.php';
            } else {
                // Người dùng nhấn Cancel
            }

        }


        const titleNameProcduct = $('.breadcrumb-list__inner.breadcrumb-arrows .active > span > strong');
        titleNameProcduct.textContent = checkVetify[0].name;

        //name and orthers
        const headingName = $('.productDetail__heading>h1');
        const priceProc = $('.productDetail-price>span');
        const soldold = $('.productDetail-soldold strong > strong');

        headingName.innerHTML = checkVetify[0].name + ` (${checkVetify[0].colors.list[0]})`;
        priceProc.innerHTML = checkVetify[0].price;

        soldold.innerHTML = checkVetify[0].colors.detail[0].detail.sort(function (a, b) {
            return parseFloat(a.size) - parseFloat(b.size);
        })[0].qty;


        //share
        const productSharing = $('.product-sharing');
        productSharing.onclick = function () {
            productSharing.classList.toggle('sharing-active');
        };


        //action value qty
        const qtyMinus = $('.productDetail__quantity-area .minus');
        const qtyPlus = $('.productDetail__quantity-area .plus');
        const valueQty = $('.productDetail__quantity-area .quantity-input');


        qtyMinus.onclick = function () {
            valueQty.value--;
            if (valueQty.value < 1) valueQty.value++;
        };


        qtyPlus.onclick = function () {
            const formAddCart = $('#add-item-form');
            let tempQty = 0;
            const data = new FormData(formAddCart);
            var detail = {};

            for (const [name, value] of data) {
                detail[`${name}`] = `${value}`;
            }

            checkVetify[0].colors.detail.find((element, index) => {
                if (element.color === detail.option1) {
                    element.detail.find((element1) => {
                        if (Number(element1.size) === Number(detail.option2)) {
                            tempQty = Number(element1.qty);
                        }
                    });
                }
            });

            valueQty.value++;
            if (valueQty.value > tempQty) valueQty.value--;
        };

        // more
        const description = $$('.productDetail__tabs li');
        for (let i = 0; i < description.length; i++) {
            description[i].onclick = function (e) {
                if (!checkNodePlus(description[i].children[1], e.target)) {
                    if (description[i].classList.contains('active')) {
                        description[i].classList.toggle('active');
                    } else {
                        for (let i = 0; i < description.length; i++) {
                            description[i].classList.remove('active');
                        }
                        description[i].classList.add('active');
                    }
                }
            };
        }


        //size

        function SizeOption(data, checked) {
            let tempSizeOption;

            if (checked) {
                tempSizeOption = `
               <div data-value="${data.size}" class="productDetail__swatch-element">
                  <input class="productDetail__variant-1"
                     id="swatch-1-${data.size}" type="radio" name="option2"
                     value="${data.size}" checked>
                  <label for="swatch-1-${data.size}"
                     class="productDetail__sd">
                     <span>${data.size}</span>
                  </label>
               </div>            
               `;
            } else {
                tempSizeOption = `
               <div data-value="${data.size}" class="productDetail__swatch-element">
                  <input class="productDetail__variant-1"
                     id="swatch-1-${data.size}" type="radio" name="option2"
                     value="${data.size}">
                  <label for="swatch-1-${data.size}">
                     <span>${data.size}</span>
                  </label>
               </div>            
               `;
            }

            return tempSizeOption;
        }




        //color
        const listColor = $('#variant-swatch-0 .productDetail__select-swap');

        listColor.innerHTML = checkVetify[0].colors.list
            .map((element, index) => {

                if (checkVetify[0].colors.detail[index].qty > 0) {
                    if (index === 0)
                        return ColorOption(
                            {
                                color: checkVetify[0].colors.detail[index].color,
                                img: checkVetify[0].colors.detail[index].imgs.firstImg,
                            },
                            true,
                        );
                    else
                        return ColorOption(
                            {
                                color: checkVetify[0].colors.detail[index].color,
                                img: checkVetify[0].colors.detail[index].imgs.firstImg,
                            },
                            false,
                        );
                }
            })
            .join('');




        // modal view product
        const viewProductMain = $('.modalViewed-product__content');
        let tempDragViewProc, tempTranslateXViewProc;

        viewProductMain.parentNode.onclick = function (e) {
            e.stopPropagation();
            viewProductMain.parentNode.style.display = 'none';
            document.body.style.overflow = 'auto';
        };


        viewProductMain.onclick = function (e) {
            e.stopPropagation();
            if (!mouseMoveViewProc) {
                viewProductMain.style.transition = 'none';
                viewProductMain.style.marginTop = `0px`;
                document.querySelector('.modalViewed-product').scrollTo(0, 0);
                setTimeout(() => {
                    if (viewProductMain.classList.contains('zoom-2')) {
                        viewProductMain.classList.remove('zoom-2');
                        viewProductMain.classList.add('zoom-4');
                        viewProductMain.style.cursor = 'zoom-out';
                        const topViewProc = viewProductMain.getBoundingClientRect().top;

                        if (topViewProc < 0) {
                            viewProductMain.style.marginTop = `${-topViewProc * 2}px`;
                            document
                                .querySelector('.modalViewed-product')
                                .scrollTo(0, document.body.clientHeight / 4);
                        }
                    } else if (viewProductMain.classList.contains('zoom-4')) {
                        viewProductMain.classList.remove('zoom-4');
                        viewProductMain.style.cursor = 'zoom-in';
                    } else {
                        viewProductMain.style.cursor = 'zoom-in';

                        viewProductMain.classList.add('zoom-2');
                        const topViewProc = viewProductMain.getBoundingClientRect().top;

                        if (topViewProc < 0) {
                            viewProductMain.style.marginTop = `${-topViewProc * 2}px`;
                            document
                                .querySelector('.modalViewed-product')
                                .scrollTo(0, document.body.clientHeight / 10);
                        }
                    }
                }, 10);
                viewProductMain.style.transform = ``;
            } else mouseMoveViewProc = false;
        };


        let flagDragViewModal = false,
            mouseMoveViewProc = false;

        function handleDragViewModal(e) {
            const x = e.clientX - tempDragViewProc;
            const leftViewProc = viewProductMain.getBoundingClientRect().left;
            const rightViewProc = viewProductMain.getBoundingClientRect().right;
            const widthViewProc = viewProductMain.getBoundingClientRect().width;
            const widthTranslateX = Math.abs((widthViewProc - document.body.clientWidth) / 2);
            const curTranslateX = tempTranslateXViewProc + x;

            if (Math.round(leftViewProc) >= 0) {
                viewProductMain.style.transform = `translateX(${widthTranslateX + (curTranslateX - widthTranslateX) / 2
                    }px)`;
            } else if (rightViewProc <= document.body.clientWidth) {
                viewProductMain.style.transform = `translateX(${-widthTranslateX + (curTranslateX + widthTranslateX) / 2
                    }px)`;
            } else viewProductMain.style.transform = `translateX(${tempTranslateXViewProc + x}px)`;
        }


        viewProductMain.onmousedown = function (e) {
            const widthViewProc = viewProductMain.getBoundingClientRect().width;
            if (widthViewProc > document.body.clientWidth) {
                viewProductMain.style.transition = 'none';
                flagDragViewModal = true;

                tempDragViewProc = e.clientX;
                tempTranslateXViewProc = +viewProductMain.style.transform
                    .replace('translateX', '')
                    .replaceAll('(', '')
                    .replaceAll(')', '')
                    .replace('px', '');
            }
        };


        viewProductMain.onmousemove = function (e) {
            const widthViewProc = viewProductMain.getBoundingClientRect().width;
            if (widthViewProc > document.body.clientWidth)
                if (flagDragViewModal) {
                    mouseMoveViewProc = true;
                    handleDragViewModal(e);
                    viewProductMain.style.cursor = 'ew-resize';
                }
        };

        viewProductMain.onmouseup = function (e) {
            const widthViewProc = viewProductMain.getBoundingClientRect().width;
            if (widthViewProc > document.body.clientWidth)
                if (flagDragViewModal) {
                    const leftViewProc = viewProductMain.getBoundingClientRect().left;
                    const widthViewProc = viewProductMain.getBoundingClientRect().width;
                    const rightViewProc = viewProductMain.getBoundingClientRect().right;
                    const widthTranslateX = (widthViewProc - document.body.clientWidth) / 2;

                    viewProductMain.style.transition = 'all 0.4s ease 0s';

                    if (leftViewProc >= 0) {
                        viewProductMain.style.transform = `translateX(${widthTranslateX}px)`;
                    } else if (rightViewProc <= document.body.clientWidth) {
                        viewProductMain.style.transform = `translateX(${-widthTranslateX}px)`;
                    }

                    if (viewProductMain.classList.contains('zoom-4')) {
                        viewProductMain.style.cursor = 'zoom-out';
                    } else viewProductMain.style.cursor = 'zoom-in';

                    flagDragViewModal = false;
                }
        };


        viewProductMain.onmouseleave = function (e) {
            const widthViewProc = viewProductMain.getBoundingClientRect().width;
            if (widthViewProc > document.body.clientWidth)
                if (flagDragViewModal) {
                    const leftViewProc = viewProductMain.getBoundingClientRect().left;
                    const widthViewProc = viewProductMain.getBoundingClientRect().width;
                    const rightViewProc = viewProductMain.getBoundingClientRect().right;
                    const widthTranslateX = (widthViewProc - document.body.clientWidth) / 2;

                    viewProductMain.style.transition = 'all 0.4s ease 0s';

                    if (leftViewProc >= 0) {
                        viewProductMain.style.transform = `translateX(${widthTranslateX}px)`;
                    } else if (rightViewProc <= document.body.clientWidth) {
                        viewProductMain.style.transform = `translateX(${-widthTranslateX}px)`;
                    }

                    flagDragViewModal = false;
                    mouseMoveViewProc = false;
                }
        };


        // product gallery
        const mainGallery = $('#productCarousel-slider .productDetail-gallery__item');
        const mainWrapperListGalleryThumb = $('#productCarousel-thumb');
        let mainGalleryThumb;
        const imgViewProc = $('.modalViewed-product__content img');
        const btnLeftGrallery = $('.fancybox-button--arrow_left');
        const btnRightGrallery = $('.fancybox-button--arrow_right');
        const formAddCart = $('#add-item-form');

        //add mainGallery and add list gallery
        const mainImgGallery = $(
            '#productCarousel-slider .productDetail-gallery__item .productDetail-gallery__item-inner img',
        );

        let listImgGallery;
        let indexGallrery = 0;


        function renderGallery() {
            const formAddCart = $('#add-item-form');

            const data = new FormData(formAddCart);
            var detail = {};
            for (const [name, value] of data) {
                detail[`${name}`] = `${value}`;
            }
            let tempIndex = -1;
            checkVetify[0].colors.detail.find((element, index) => {
                if (element.color.toLowerCase() === detail.option1.trim().toLowerCase()) tempIndex = index;

                return element.color.toLowerCase() === detail.option1.trim().toLowerCase();
            });

            if (tempIndex != -1) {
                const listSize = $('#variant-swatch-1 .productDetail__sub-swap');

                listSize.innerHTML = checkVetify[0].colors.detail[tempIndex].detail
                    .sort((a, b) =>
                        Number(a.size) > Number(b.size) ? 1 : Number(a.size) < Number(b.size) ? -1 : 0,
                    )
                    .map((element, index) => {
                        if (element.qty > 0) {
                            if (index === 0) return SizeOption(element, true);
                            else return SizeOption(element, false);
                        }
                    })
                    .join('');

                listImgGallery = [
                    checkVetify[0].colors.detail[tempIndex].imgs.firstImg,
                    checkVetify[0].colors.detail[tempIndex].imgs.secondeImg,
                ].concat(checkVetify[0].colors.detail[tempIndex].imgs.orthers);

                listImgGallery = listImgGallery.filter(item => item !== "");

                mainImgGallery.src = checkVetify[0].colors.detail[tempIndex].imgs.firstImg;

                var listImgGalleryTempInner = [
                    checkVetify[0].colors.detail[tempIndex].imgs.secondeImg,
                ]
                    .concat(checkVetify[0].colors.detail[tempIndex].imgs.orthers)
                    .map((element) => {
                        if (element) {
                            return ProductGalleryThumb({ img: element, name: checkVetify[0].name });
                        } else
                            return;
                    });

                listImgGalleryTempInner = listImgGalleryTempInner.filter(item => item !== undefined);

                mainWrapperListGalleryThumb.innerHTML = listImgGalleryTempInner
                    .join('');
            } else {
                mainImgGallery.src = checkVetify[0].colors.detail[0].imgs.firstImg;

                mainWrapperListGalleryThumb.innerHTML = [checkVetify[0].colors.detail[0].imgs.secondeImg]
                    .concat(checkVetify[0].colors.detail[0].imgs.orthers)
                    .map((element, index) => ProductGalleryThumb({ img: element, name: checkVetify[0].name }))
                    .join('');
            }
        }

        renderGallery();


        mainGallery.onclick = function () {
            viewProductMain.parentNode.style.display = 'flex';
            viewProductMain.classList.remove('zoom-2');
            viewProductMain.classList.remove('zoom-4');
            viewProductMain.style.marginTop = `0px`;
            viewProductMain.style.transform = ``;
            document.body.style.overflow = 'hidden';

            const tempSrc = mainImgGallery.src;

            listImgGallery.find((element, index) => {
                indexGallrery = index;
                return element === tempSrc;
            });

            imgViewProc.src = listImgGallery[indexGallrery];
        };

        function handleListGallery() {
            setTimeout(() => {
                //product size
                const itemSize = $$(
                    '#variant-swatch-1 .productDetail__sub-swap .productDetail__swatch-element',
                );
                for (let i = 0; i < itemSize.length; i++) {
                    itemSize[i].onclick = function () {
                        itemSize[i].children[0].click();

                        const data = new FormData(formAddCart);
                        var detail = {};

                        for (const [name, value] of data) {
                            detail[`${name}`] = `${value}`;
                        }

                        checkVetify[0].colors.detail.find((element, index) => {
                            if (element.color === detail.option1) {
                                element.detail.find((element1, index1) => {
                                    if (Number(element1.size) === Number(detail.option2)) {
                                        soldold.innerHTML = element1.qty;
                                    }
                                });
                            }
                        });

                        for (let i = 0; i < itemSize.length; i++) {
                            itemSize[i].children[1].className = '';
                        }
                        itemSize[i].children[1].className = 'productDetail__sd';
                    };
                }

                mainGalleryThumb = $$('#productCarousel-thumb .productDetail-gallery__thumb-item');

                //onload
                for (let i = 0; i < mainGalleryThumb.length; i++) {
                    mainGalleryThumb[i].addEventListener('click', () => {
                        viewProductMain.parentNode.style.display = 'flex';
                        viewProductMain.classList.remove('zoom-2');
                        viewProductMain.classList.remove('zoom-4');
                        viewProductMain.style.marginTop = `0px`;
                        viewProductMain.style.transform = ``;
                        document.body.style.overflow = 'hidden';

                        const tempSrc = mainGalleryThumb[i].children[0].children[0].src;
                        listImgGallery.filter((element, index) => {
                            if (element === tempSrc) indexGallrery = index;
                            return element === tempSrc;
                        });
                        imgViewProc.src = listImgGallery[indexGallrery];
                    });
                }
            });
        }
        handleListGallery();

        btnRightGrallery.onclick = function (e) {
            e.stopPropagation();
            viewProductMain.classList.remove('zoom-2');
            viewProductMain.classList.remove('zoom-4');
            viewProductMain.style.marginTop = `0px`;
            viewProductMain.style.transform = ``;

            indexGallrery++;

            if (indexGallrery > listImgGallery.length - 1) indexGallrery = 0;
            if (viewProductMain.classList.contains('zoom-4')) {
                viewProductMain.style.cursor = 'zoom-out';
            } else viewProductMain.style.cursor = 'zoom-in';
            imgViewProc.src = listImgGallery[indexGallrery];
        };

        btnLeftGrallery.onclick = function (e) {
            e.stopPropagation();
            viewProductMain.classList.remove('zoom-2');
            viewProductMain.classList.remove('zoom-4');
            viewProductMain.style.marginTop = `0px`;
            viewProductMain.style.transform = ``;

            indexGallrery--;

            if (indexGallrery < 0) indexGallrery = listImgGallery.length - 1;
            if (viewProductMain.classList.contains('zoom-4')) {
                viewProductMain.style.cursor = 'zoom-out';
            } else viewProductMain.style.cursor = 'zoom-in';
            imgViewProc.src = listImgGallery[indexGallrery];
        };



        //detail Product Gallery
        const detailProductGallery = $('#detailProductGallery');

        detailProductGallery.innerHTML = `<span>${checkVetify[0].description}</span>`;

        //product color
        const itemColor = $$(
            '#variant-swatch-0 .productDetail__select-swap .productDetail__swatch-element',
        );

        for (let i = 0; i < itemColor.length; i++) {
            itemColor[i].onclick = function () {
                itemColor[i].children[0].click();
                const data = new FormData(formAddCart);
                var detail = {};

                for (const [name, value] of data) {
                    detail[`${name}`] = `${value}`;
                }

                checkVetify[0].colors.detail.find((element, index) => {
                    if (element.color === detail.option1) {
                        headingName.innerHTML = checkVetify[0].name + ` (${element.color})`;
                        element.detail.find((element1, index1) => {
                            if (Number(element1.size) === Number(detail.option2)) {
                                soldold.innerHTML = element1.qty;
                            }
                        });
                    }
                });
                for (let i = 0; i < itemColor.length; i++) {
                    itemColor[i].children[1].classList.remove('productDetail__sd');
                }
                itemColor[i].children[1].classList.add('productDetail__sd');

                renderGallery();
                handleListGallery();
            };
        }


    })
    .catch(error => {
        console.error(error);
    });


//start


if (shareLink) {
    shareLink.onclick = function myFunction() {
        // Get the text field
        var copyText = document.getElementById('url_copy_product');
        copyText.value = window.location.href;
        // Select the text field
        copyText.select();

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
    };
}


function ProductGalleryThumb({ img, name }) {
    return `
       <li class="productDetail-gallery__thumb-item 1"
       data-image="${img}">
          <div data-fancybox="gallery"
             class="productDetail-gallery__thumb-item-inner"
             href="${img}">
             <img src="${img}"
                alt="${name}"
                onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                >
          </div>
       </li>
    `;
}


const getAllProduct = () => {
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


                            const listOther = [itemDetail[8] || null, itemDetail[9] || null, itemDetail[10] || null, itemDetail[11] || null]

                            return {
                                color: itemDetail[13],
                                imgs: {
                                    firstImg: itemDetail[6] || null,
                                    secondeImg: itemDetail[7] || null,
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
            // Recommend Product


            const listRecommedPro = $('#owlProduct-related');


            const wapperListRecom = $('#listViewed');


            let dataRecommendProc = ListProduct.map((element) => {
                let tempNewPrice = Number(element.price.replaceAll(',', ''));

                tempNewPrice = tempNewPrice * (100 - Number(element.promotions));
                return Product({
                    _id: element._id,
                    name: element.name,
                    price: element.price,
                    color: element.colors,
                    sizes: element.size,
                    promotional_price: "",
                    promotion_percentage: "",
                    news: element.newProc,
                });
            });


            listRecommedPro.innerHTML = dataRecommendProc
                .slice(0, 6)
                .map((element) => element)
                .join('');


            wapperListRecom.innerHTML = ListDragProc(1, dataRecommendProc.slice(0, 6));

        })
        .catch(error => {
            console.error(error);
        });
}

getAllProduct();