import Product from './productItem.js';

const $ = document.querySelector.bind(document);

//routing
const urlParams = new URLSearchParams(window.location.search);
const titleCategory = $('#collection_title_category');
const categoryLocation = $('#category__loaction');

titleCategory.innerHTML = urlParams.get('title');
categoryLocation.innerHTML = ` <strong style="font-weight: bold;">${urlParams.get('title')}</strong>`;

const checkNode = (parent, children) => {
    let node = children.parentNode;
    while (node !== null) {
        if (node === parent) return true;
        node = node.parentNode;
    }
    return false;
};

//Filter Desktop
var filterItems = document.querySelectorAll('.filter-desktop-item');
const filterItemLength = filterItems.length;
function hidefilterItem(filterItem) {
    filterItem.classList.remove('active');
}

function showfilterItem(filterItem) {
    filterItem.classList.add('active');
}

for (let filterItem of filterItems) {
    filterItem.onclick = (e) => {
        var result = checkNode(filterItem, e.target);

        if (filterItem.classList.contains('active')) {
            hidefilterItem(filterItem);
        } else {
            var filterItemActive1 = document.querySelector('.filter-desktop-item.active');
            if (filterItemActive1) {
                hidefilterItem(filterItemActive1);
            }
            showfilterItem(filterItem);
        }
        if (result) {
            showfilterItem(filterItem);
        }
    };
}



//Filter Desktop li
var filterColors = document.querySelectorAll('.filter-color li label');
var filterSizes = document.querySelectorAll('.filter-size li label');

var filterLis = document.querySelectorAll('.checkbox-list li label');
var filterDesc = document.querySelector('.active-filter');
var filterLisLength = filterLis.length;
var valueOfLi = [];
var valueColors = [];
var valueSizes = [];
var htmlLi = [];

function searchProductColor(productList, arrayColor) {
    var productFilterList = [];
    for (let i = 0; i < productList.length; i++) {
        for (let j = 0; j < arrayColor.length; j++) {
            for (let m = 0; m < productList[i].colors.list.length; m++) {
                if (productList[i].colors.list[m] == arrayColor[j]) {
                    productFilterList.push(productList[i]);
                }
            }
        }
    }
    return productFilterList;
}

function searchProductSize(productList, arraySize) {
    var productFilterList = [];
    for (let i = 0; i < productList.length; i++) {
        for (let j = 0; j < arraySize.length; j++) {
            for (let m = 0; m < productList[i].size.length; m++) {
                if (productList[i].size[m] == arraySize[j]) {
                    productFilterList.push(productList[i]);
                }
            }
        }
    }
    return productFilterList;
}

function searchProductPrice(productList, price) {
    var productFilterList = [];
    for (let i = 0; i < productList.length; i++) {
        const productPrice = Number(productList[i].price.split(',').join(''));
        if (productPrice >= price.minPriceSearch && productPrice <= price.maxPriceSearch) {
            productFilterList.push(productList[i]);
        }
    }
    return productFilterList;
}

function searchProductSizePrice(productList, arraySize, price) {
    var productFilterList = [];
    for (let i = 0; i < productList.length; i++) {
        const productPrice = Number(productList[i].price.split(',').join(''));
        if (productPrice >= price.minPriceSearch && productPrice <= price.maxPriceSearch) {
            for (let j = 0; j < arraySize.length; j++) {
                for (let m = 0; m < productList[i].size.length; m++) {
                    if (productList[i].size[m] == arraySize[j]) {
                        productFilterList.push(productList[i]);
                    }
                }
            }
        }
    }
    return productFilterList;
}

function searchProductColorPrice(productList, arrayColor, price) {
    var productFilterList = [];
    for (let i = 0; i < productList.length; i++) {
        const productPrice = Number(productList[i].price.split(',').join(''));
        if (productPrice >= price.minPriceSearch && productPrice <= price.maxPriceSearch) {
            for (let j = 0; j < arrayColor.length; j++) {
                for (let m = 0; m < productList[i].colors.list.length; m++) {
                    if (productList[i].colors.list[m] == arrayColor[j]) {
                        productFilterList.push(productList[i]);
                    }
                }
            }
        }
    }
    return productFilterList;
}

function searchProductColorSize(productList, arrayColor, arraySize) {
    var productFilterList = [];
    productFilterList = searchProductColor(productList, arrayColor);
    productFilterList = searchProductSize(productFilterList, arraySize);
    return productFilterList;
}

//tu do



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
    action: 'all_product_with_category',
    value: urlParams.get('value')
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

        return ListProduct = ListProduct.filter(item => item !== undefined);
    }).then((productListReal) => {

        //tu do
        for (let i = 0; i < filterColors.length; i++) {
            let filterColor = filterColors[i];
            filterColor.addEventListener('click', function (e) {
                if (filterColor.parentElement.classList.contains('active')) {
                    filterColor.parentElement.classList.remove('active');
                    let valueColorLength = valueColors.length;
                    for (let i = 0; i < valueColorLength; i++) {
                        if (valueColors[i] == filterColor.innerText) {
                            valueColors.splice(i, 1);
                        }
                    }
                } else {
                    filterColor.parentElement.classList.add('active');
                    valueColors.push(filterColor.innerText);
                }
                // valueOfLi.splice(0,1,valueColors);
                valueOfLi[0] = valueColors;
                let valueOfColor = getHTMLtoFilterDesc(valueOfLi[0]);
                htmlLi[0] = valueOfColor.join('');
                filterDesc.innerHTML = htmlLi.join('');
                if (valueColors.length > 0 && valueOfLi[1] == undefined && valueOfLi[2] == undefined) {
                    productFilterList = searchProductColor(productListReal, valueOfLi[0]);
                } else if (valueOfLi[1] != undefined || valueOfLi[2] != undefined) {
                    productFilterList = searchProductColor(productFilterList, valueOfLi[0]);
                } else {
                    productFilterList = productListReal;
                }
                if (valueColors.length == 0) {
                    if (valueSizes.length == 0 && valueOfLi[2] == undefined) {
                        productFilterList = productListReal;
                    } else if (valueSizes.length > 0 && valueOfLi[2] == undefined) {
                        productFilterList = searchProductSize(productListReal, valueOfLi[1]);
                    } else if (
                        valueSizes.length == 0 ||
                        (valueOfLi[1] == undefined && valueOfLi[2] != undefined)
                    ) {
                        productFilterList = searchProductPrice(productListReal, valueOfLi[2]);
                    } else {
                        productFilterList = searchProductSizePrice(productListReal, valueOfLi[1], valueOfLi[2]);
                    }
                }
                // console.log(productFilterList);
                var dataProduct = htmlProduct(productFilterList);
                if (productFilterList.length > 0) {
                    for (let i = 0; i < dataProduct.length; i++) {
                        wrapList.innerHTML = dataProduct.join('');
                    }
                } else {
                    wrapList.innerHTML = dataProduct;
                }
            });
        }

        for (let i = 0; i < filterSizes.length; i++) {
            let filterSize = filterSizes[i];
            filterSize.addEventListener('click', function (e) {
                if (filterSize.parentElement.classList.contains('active')) {
                    filterSize.parentElement.classList.remove('active');
                    let valueSizeLength = valueSizes.length;
                    for (let i = 0; i < valueSizeLength; i++) {
                        if (valueSizes[i] == filterSize.innerText) {
                            valueSizes.splice(i, 1);
                        }
                    }
                } else {
                    filterSize.parentElement.classList.add('active');
                    valueSizes.push(filterSize.innerText);
                }
                valueOfLi[1] = valueSizes;
                let valueOfSize = getHTMLtoFilterDesc(valueOfLi[1]);
                htmlLi[1] = valueOfSize.join('');
                filterDesc.innerHTML = htmlLi.join('');
                if (valueOfLi[1].length > 0 && valueOfLi[0] == undefined && valueOfLi[2] == undefined) {
                    productFilterList = searchProductSize(productListReal, valueOfLi[1]);
                } else if (valueOfLi[0] != undefined || valueOfLi[2] != undefined) {
                    productFilterList = searchProductSize(productFilterList, valueOfLi[1]);
                } else {
                    productFilterList = productListReal;
                }
                if (valueSizes.length == 0) {
                    if (valueColors.length == 0 && valueOfLi[2] == undefined) {
                        productFilterList = productListReal;
                    } else if (valueColors.length > 0 && valueOfLi[2] == undefined) {
                        productFilterList = searchProductColor(productListReal, valueOfLi[0]);
                    } else if (
                        valueColors.length == 0 ||
                        (valueOfLi[0] == undefined && valueOfLi[2] != undefined)
                    ) {
                        productFilterList = searchProductPrice(productListReal, valueOfLi[2]);
                    } else {
                        productFilterList = searchProductColorPrice(productListReal, valueOfLi[0], valueOfLi[2]);
                    }
                }
                // console.log(productFilterList);
                var dataProduct = htmlProduct(productFilterList);
                if (productFilterList.length > 0) {
                    for (let i = 0; i < dataProduct.length; i++) {
                        wrapList.innerHTML = dataProduct.join('');
                    }
                } else {
                    wrapList.innerHTML = dataProduct;
                }
            });
        }

        function getHTMLtoFilterDesc(valueOfLi) {
            var filterdesc = valueOfLi.map(function (value) {
                return `
         <span class="filter-item" data-value="${value}">${value}
         <i class="fa-sharp fa-solid fa-circle-xmark"></i>
         </span>
      `;
            });
            return filterdesc;
        }

        function getHTMLtoFilterPrice(value) {
            return `
      <div class="price" minprice="${value.minPriceSearch}" maxprice="${value.maxPriceSearch}">
         ${format2(value.minPriceSearch)} - ${format2(value.maxPriceSearch)} đ
         <i class="fa fa-times-circle"></i>
      </div>
   `;
        }

        filterDesc.onclick = (e) => {
            if (e.target != filterDesc) {
                var valueParent = e.target.parentElement.innerText;
                let valueLength1 = valueOfLi.length;
                let minPrice = Number(amount.getAttribute('minpricesearch'));
                let maxPrice = Number(amount.getAttribute('maxpricesearch'));

                if (e.target.parentElement.classList.contains('price')) {
                    valueOfLi.pop();
                    htmlLi.pop();
                    if (
                        (valueOfLi[0] == undefined && valueOfLi[1] == undefined) ||
                        (valueColors.length == 0 && valueSizes.length == 0)
                    ) {
                        productFilterList = productListReal;
                    } else if (valueColors.length > 0 && valueOfLi[1] == undefined) {
                        productFilterList = searchProductColor(productListReal, valueOfLi[0]);
                    } else if (valueSizes.length > 0 && valueOfLi[0] == undefined) {
                        productFilterList = searchProductSize(productListReal, valueOfLi[1]);
                    } else {
                        productFilterList = searchProductColorSize(productListReal, valueOfLi[0], valueOfLi[1]);
                    }
                }
                if (e.target.parentElement.classList.contains('filter-item')) {
                    if (valueOfLi[0]) {
                        for (let i = 0; i < valueOfLi[0].length; i++) {
                            if (valueOfLi[0][i] === valueParent) {
                                valueOfLi[0].splice(i, 1);
                                let valueOfColor = getHTMLtoFilterDesc(valueOfLi[0]);
                                htmlLi[0] = valueOfColor.join('');
                                if (valueOfLi[0].length > 0) {
                                    productFilterList = searchProductColor(productListReal, valueOfLi[0]);
                                } else if (valueOfLi[0].length == 0) {
                                    if (valueSizes.length == 0 && valueOfLi[2] == undefined) {
                                        productFilterList = productListReal;
                                    } else if (valueSizes.length > 0 && valueOfLi[2] == undefined) {
                                        productFilterList = searchProductSize(productListReal, valueOfLi[1]);
                                    } else if (
                                        valueSizes.length == 0 ||
                                        (valueOfLi[1] == undefined && valueOfLi[2] != undefined)
                                    ) {
                                        productFilterList = searchProductPrice(productListReal, valueOfLi[2]);
                                    } else {
                                        productFilterList = searchProductSizePrice(
                                            productListReal,
                                            valueOfLi[1],
                                            valueOfLi[2],
                                        );
                                    }
                                }
                            }
                        }
                    }
                    if (valueOfLi[1]) {
                        for (let i = 0; i < valueOfLi[1].length; i++) {
                            if (valueOfLi[1][i] === valueParent) {
                                valueOfLi[1].splice(i, 1);
                                let valueOfSize = getHTMLtoFilterDesc(valueOfLi[1]);
                                htmlLi[1] = valueOfSize.join('');
                                if (valueOfLi[1].length > 0) {
                                    productFilterList = searchProductSize(productListReal, valueOfLi[1]);
                                } else if (valueOfLi[1].length == 0) {
                                    if (valueColors.length == 0 && valueOfLi[2] == undefined) {
                                        productFilterList = productListReal;
                                    } else if (valueColors.length > 0 && valueOfLi[2] == undefined) {
                                        productFilterList = searchProductColor(productListReal, valueOfLi[0]);
                                    } else if (
                                        valueColors.length == 0 ||
                                        (valueOfLi[0] == undefined && valueOfLi[2] != undefined)
                                    ) {
                                        productFilterList = searchProductPrice(productListReal, valueOfLi[2]);
                                    } else {
                                        productFilterList = searchProductColorPrice(
                                            productListReal,
                                            valueOfLi[0],
                                            valueOfLi[2],
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                filterDesc.innerHTML = htmlLi.join('');
                var dataProduct = htmlProduct(productFilterList);
                if (productFilterList.length > 0) {
                    for (let i = 0; i < dataProduct.length; i++) {
                        wrapList.innerHTML = dataProduct.join('');
                    }
                } else {
                    wrapList.innerHTML = dataProduct;
                }
                var filterLiActives = document.querySelectorAll('.checkbox-list li.active');
                for (let filterLiActive of filterLiActives) {
                    if (filterLiActive.children[1].innerText === valueParent) {
                        filterLiActive.classList.remove('active');
                    }
                }

                uisliderRange.style.width = '100%';
                uisliderRange.style.left = '0%';
                uisliderHandles[0].style.left = '0%';
                uisliderHandles[1].style.left = '100%';
                const maxprice = 2000000;
                const minprice = 0;
                amount.setAttribute('minpricesearch', minprice);
                amount.setAttribute('maxpricesearch', maxprice);
                amountText.innerHTML = `${format2(minprice)} đ - ${format2(maxprice)} đ`;
            }
        };

        //Filter-SortBy Icon
        var sortItems = document.querySelectorAll(
            '.wrapper-mainCollection .collection-sortbyfilter-container .collection-sortby-option ul.sort-by li',
        );
        for (let sortItem of sortItems) {
            sortItem.onclick = () => {
                let sortItemActive = document.querySelector(
                    '.collection-sortbyfilter-container .collection-sortby-option ul.sort-by li.active',
                );
                if (sortItemActive) {
                    sortItemActive.classList.remove('active');
                }
                sortItem.classList.add('active');
            };
        }
        //
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

        //Product List Lọc
        var tempLength = 0;

        // var productListReal = JSON.parse(localStorage.getItem(localKey));
        var wrapList = document.querySelector('.collection-list');
        var productFilterList = [];

        function htmlProduct(arrayProduct) {
            if (arrayProduct.length == 0) {
                const btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
                btnLoadMore.style.display = 'none';



                return [];
            } else {
                if (tempLength === 0) tempLength = 8;
                const btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
                if (arrayProduct.length > tempLength) {
                    btnLoadMore.style.display = 'inline-block';
                } else {
                    btnLoadMore.style.display = 'none';
                }

                var newArrayProduct = arrayProduct.map(function (element) {
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
                return newArrayProduct;
            }
        }

        // function checkId(product, productlist) {
        //     let check = true;
        //     const length = productlist.length;
        //     for (let i = 0; i < length; i++) {
        //         if (product._id == productlist[i]._id) {
        //             check = false;
        //             break;
        //         }
        //     }
        //     return check;
        // }

        var dataProduct;

        dataProduct = htmlProduct(
            productListReal
        ).slice(0, tempLength);

        //Hiện sản phẩm
        if (dataProduct.length > 0) {
            wrapList.innerHTML = dataProduct.join('');
        } else {

            wrapList.innerHTML = `
            <div class="row listProduct-row listProduct-resize listProduct-filter" style="
            margin: auto;
            font-weight: 700;
        ">
                <div class="col-md-12 product-noloop">
                <div class="collection-alert-no">
                    <p>Không tìm thấy kết quả!</p>
                </div>
                </div>
            </div>
            `;
        }

        var btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
        btnLoadMore.onclick = () => {
            tempLength += 8;
            dataProduct = htmlProduct(
                productListReal
            ).slice(0, tempLength);

            wrapList.innerHTML = dataProduct.join('');
            // setTimeout(() => {
            //     var btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
            //     if (productListReal.filter((element) => element.shoeTypes.gender === 'Nam').length > tempLength) {
            //         btnLoadMore.style.display = 'inline-block';
            //     } else btnLoadMore.style.display = 'none';
            // });
        };

        //Drag and drop
        const sliderRange = document.querySelector('#slider-range');
        const uisliderRange = sliderRange.querySelector('.ui-widget-header');
        const uisliderHandles = sliderRange.querySelectorAll('.ui-slider-handle');
        var amount = document.querySelector('#amount');
        var amountText = document.querySelector('#amount-text');

        var isReadytoDrag = false;
        var drop = 0; //Biến kiểm tra chọn handle trái hay phải

        window.addEventListener('click', function (e) {
            for (let i = 0; i < filterItemLength - 1; i++) {
                var checknode = checkNode(filterItems[i], e.target);
                if (!checknode && e.target !== filterItems[i]) {
                    hidefilterItem(filterItems[i]);
                }
            }
            if (uisliderHandles) {
                for (let uisliderHandle of uisliderHandles) {
                    uisliderHandle.classList.remove('ui-state-hover');
                }
            }
        });

        sliderRange.addEventListener('mousedown', (e) => {
            isReadytoDrag = true;
        });

        for (let uisliderHandle of uisliderHandles) {
            uisliderHandle.addEventListener('mouseenter', (e) => {
                uisliderHandle.classList.add('ui-state-hover');
            });
        }

        // Handle LEFT
        uisliderHandles[0].addEventListener('mousedown', (e) => {
            drop = 1;
            uisliderHandles[0].classList.add('ui-state-active');
            document.addEventListener('mousemove', (e) => {
                const clientX = e.clientX;
                const left = Math.ceil(sliderRange.getBoundingClientRect().left);
                const uiLeft = Math.ceil(uisliderRange.getBoundingClientRect().left);
                const uiRight = Math.ceil(uisliderRange.getBoundingClientRect().right);

                const min = left;
                const max = uiRight + 1;

                if (isReadytoDrag && drop == 1 && clientX >= min && clientX <= max) {
                    const move = clientX - uiLeft;
                    var uiStyleLeft = Number(uisliderRange.style.left.split('%')[0]);
                    var uiStyleWidth = Number(uisliderRange.style.width.split('%')[0]);
                    const step = 2.5;
                    let minPrice = Number(amount.getAttribute('minpricesearch'));
                    let maxPrice = Number(amount.getAttribute('maxpricesearch'));
                    if (move >= 12) {
                        uiStyleLeft += step;
                        uisliderRange.style.left = uiStyleLeft + '%';
                        uiStyleWidth -= step;
                        uisliderRange.style.width = uiStyleWidth + '%';
                        uisliderHandles[0].style.left = uiStyleLeft + '%';
                        minPrice += 50000;
                        amount.setAttribute('minpricesearch', minPrice);
                        amountText.innerHTML = `${format2(minPrice)} đ - ${format2(maxPrice)} đ`;
                    } else if (move <= -12) {
                        uiStyleLeft -= step;
                        uisliderRange.style.left = uiStyleLeft + '%';
                        uiStyleWidth += step;
                        uisliderRange.style.width = uiStyleWidth + '%';
                        uisliderHandles[0].style.left = uiStyleLeft + '%';

                        minPrice -= 50000;
                        amount.setAttribute('minpricesearch', minPrice);
                        amountText.innerHTML = `${format2(minPrice)} đ - ${format2(maxPrice)} đ`;
                    }
                }
            });
        });

        //Handle RIGHT
        uisliderHandles[1].addEventListener('mousedown', (e) => {
            drop = 2;
            uisliderHandles[1].classList.add('ui-state-active');
            document.addEventListener('mousemove', (e) => {
                const clientX = e.clientX;

                const right = Math.ceil(sliderRange.getBoundingClientRect().right);
                const uiRight = Math.ceil(uisliderRange.getBoundingClientRect().right);
                const uiLeft = Math.ceil(uisliderRange.getBoundingClientRect().left);

                const max = right;
                const min = uiLeft;

                if (isReadytoDrag && drop == 2 && clientX <= max && clientX >= min) {
                    const move = uiRight - clientX;
                    var uiHandleRight = Number(uisliderHandles[1].style.left.split('%')[0]);
                    var uiStyleWidth = Number(uisliderRange.style.width.split('%')[0]);
                    const step = 2.5;
                    let minPrice = Number(amount.getAttribute('minpricesearch'));
                    let maxPrice = Number(amount.getAttribute('maxpricesearch'));
                    if (move >= 12) {
                        uiHandleRight -= step;
                        uiStyleWidth -= step;
                        uisliderRange.style.width = uiStyleWidth + '%';
                        uisliderHandles[1].style.left = uiHandleRight + '%';
                        maxPrice -= 50000;
                        amount.setAttribute('maxpricesearch', maxPrice);
                        amountText.innerHTML = `${format2(minPrice)} đ - ${format2(maxPrice)} đ`;
                    } else if (move <= -12) {
                        uiHandleRight += step;
                        uiStyleWidth += step;
                        uisliderRange.style.width = uiStyleWidth + '%';
                        uisliderHandles[1].style.left = uiHandleRight + '%';
                        maxPrice += 50000;
                        amount.setAttribute('maxpricesearch', maxPrice);
                        amountText.innerHTML = `${format2(minPrice)} đ - ${format2(maxPrice)} đ`;
                    }
                }
            });
        });

        document.addEventListener('mouseup', (e) => {
            uisliderHandles[0].classList.remove('ui-state-active');
            uisliderHandles[1].classList.remove('ui-state-active');

            if (isReadytoDrag) {
                let minprice = amount.getAttribute('minpricesearch');
                let maxprice = amount.getAttribute('maxpricesearch');
                var valuePriceSearch = {
                    minPriceSearch: Number(minprice),
                    maxPriceSearch: Number(maxprice),
                };
                valueOfLi[2] = valuePriceSearch;
                let valueOfPrice = getHTMLtoFilterPrice(valueOfLi[2]);
                htmlLi[2] = valueOfPrice;
                filterDesc.innerHTML = htmlLi.join('');
                if (valueOfLi[0] == undefined && valueOfLi[1] == undefined) {
                    productFilterList = searchProductPrice(productListReal, valueOfLi[2]);
                } else if (valueOfLi[0] != undefined || valueOfLi[1] != undefined) {
                    productFilterList = searchProductPrice(productFilterList, valueOfLi[2]);
                }
                var dataProduct = htmlProduct(productFilterList);
                if (productFilterList.length > 0) {
                    for (let i = 0; i < dataProduct.length; i++) {
                        wrapList.innerHTML = dataProduct.slice(0, tempLength).join('');
                    }
                } else {
                    wrapList.innerHTML = dataProduct;
                }
            }
            isReadytoDrag = false;
        });

        document.addEventListener('mouseover', (e) => {
            for (let uisliderHandle of uisliderHandles) {
                uisliderHandle.classList.remove('ui-state-hover');
            }
        });

    })
    .catch(error => {
        console.error(error);
    });

//đổi thành số tiền vnđ
function format2(n) {
    return n
        .toFixed(2)
        .replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
        .split('.')[0];
}
