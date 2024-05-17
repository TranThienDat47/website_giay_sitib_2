import InfiniteSlide from '../components/InfiniteSlide/index.js';
import Product from './productItem.js';

const $ = document.querySelector.bind(document);

let listCategory = [
    {
        collection: '',
        title: 'Nam',
        detail: [
            {
                second: 'Hunter',
                third: [],
                collection: '/collections/nam/index.html?type=hunter-nam',
            },
            {
                second: 'Sandal',
                third: [],
                collection: '/collections/nam/index.html?type=sandal-nam-1',
            },
            {
                second: 'Giày Thể Thao',
                third: [],
                collection: '/collections/nam/index.html?type=giay-the-thao-nam',
            },
            {
                second: 'Giày Chạy Bộ',
                third: [],
                collection: '/collections/nam/index.html?type=hunter-running-nam',
            },
            {
                second: 'Giày Đá Banh',
                third: [],
                collection: '/collections/nam/index.html?type=giay-da-banh',
            },
            {
                second: 'Giày Tây',
                third: [],
                collection: '/collections/nam/index.html?type=giay-tay-nam',
            },
            { second: 'Dép', third: [], collection: '/collections/nam/index.html?type=dep-nam' },
            {
                second: 'Phụ Kiện',
                third: [],
                collection: '/collections/nam/index.html?type=phu-kien',
            },
        ],
    },
    {
        collection: 'nu',
        title: 'Nữ',
        detail: [
            {
                second: 'Hunter',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=hunter',
            },
            {
                second: 'GOSTO',
                third: [
                    {
                        name: 'Giày Tao Gót',
                        collection: '/collections/nam/index.html?collection=nu&floor=3&type=giay-cao-got',
                    },
                    {
                        name: 'Giày Thời Trang',
                        collection:
                            '/collections/nam/index.html?collection=nu&floor=3&type=giay-the-thao-gosto',
                    },
                    {
                        name: 'Sandal',
                        collection: '/collections/nam/index.html?collection=nu&floor=3&type=sandal-gosto',
                    },
                    {
                        name: 'Dép',
                        collection: '/collections/nam/index.html?collection=nu&floor=3&type=dep-gosto',
                    },
                ],
                collection: '/',
            },
            {
                second: 'Sandal',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=sandal-nu-1',
            },
            {
                second: 'Giày Búp Bê',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=giay-bup-be-nu',
            },
            {
                second: 'Giày Thời Trang',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=giay-thoi-trang-nu-1',
            },
            {
                second: 'Giày Chạy Bộ - Đi Bộ',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=hunter-running-jogging',
            },
            {
                second: 'Giày Thể Thao Nữ',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=giay-the-thao-nu',
            },
            {
                second: 'Dép',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=dep-nu',
            },
            {
                second: 'Túi xách',
                third: [],
                collection: '/collections/nam/index.html?collection=nu&type=tui-xach',
            },
        ],
    },
];

//routing
const urlParams = new URLSearchParams(window.location.search);
const titleCategory = $('#collection_title_category');
// const titleCategoryList = $('#collection_list_category');
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

//Text Slide
// var textSlide = document.querySelector('.text-slide');


// textSlide.innerHTML = InfiniteSlide(10);

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

window.addEventListener('click', function (e) {
    for (let i = 0; i < filterItemLength - 1; i++) {
        var checknode = checkNode(filterItems[i], e.target);
        if (!checknode && e.target !== filterItems[i]) {
            hidefilterItem(filterItems[i]);
        }
    }
    for (let uisliderHandle of uisliderHandles) {
        uisliderHandle.classList.remove('ui-state-hover');
    }
});

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
            productFilterList = searchProductColor(productList, valueOfLi[0]);
        } else if (valueOfLi[1] != undefined || valueOfLi[2] != undefined) {
            productFilterList = searchProductColor(productFilterList, valueOfLi[0]);
        } else {
            productFilterList = productList;
        }
        if (valueColors.length == 0) {
            if (valueSizes.length == 0 && valueOfLi[2] == undefined) {
                productFilterList = productList;
            } else if (valueSizes.length > 0 && valueOfLi[2] == undefined) {
                productFilterList = searchProductSize(productList, valueOfLi[1]);
            } else if (
                valueSizes.length == 0 ||
                (valueOfLi[1] == undefined && valueOfLi[2] != undefined)
            ) {
                productFilterList = searchProductPrice(productList, valueOfLi[2]);
            } else {
                productFilterList = searchProductSizePrice(productList, valueOfLi[1], valueOfLi[2]);
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
            productFilterList = searchProductSize(productList, valueOfLi[1]);
        } else if (valueOfLi[0] != undefined || valueOfLi[2] != undefined) {
            productFilterList = searchProductSize(productFilterList, valueOfLi[1]);
        } else {
            productFilterList = productList;
        }
        if (valueSizes.length == 0) {
            if (valueColors.length == 0 && valueOfLi[2] == undefined) {
                productFilterList = productList;
            } else if (valueColors.length > 0 && valueOfLi[2] == undefined) {
                productFilterList = searchProductColor(productList, valueOfLi[0]);
            } else if (
                valueColors.length == 0 ||
                (valueOfLi[0] == undefined && valueOfLi[2] != undefined)
            ) {
                productFilterList = searchProductPrice(productList, valueOfLi[2]);
            } else {
                productFilterList = searchProductColorPrice(productList, valueOfLi[0], valueOfLi[2]);
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
                productFilterList = productList;
            } else if (valueColors.length > 0 && valueOfLi[1] == undefined) {
                productFilterList = searchProductColor(productList, valueOfLi[0]);
            } else if (valueSizes.length > 0 && valueOfLi[0] == undefined) {
                productFilterList = searchProductSize(productList, valueOfLi[1]);
            } else {
                productFilterList = searchProductColorSize(productList, valueOfLi[0], valueOfLi[1]);
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
                            productFilterList = searchProductColor(productList, valueOfLi[0]);
                        } else if (valueOfLi[0].length == 0) {
                            if (valueSizes.length == 0 && valueOfLi[2] == undefined) {
                                productFilterList = productList;
                            } else if (valueSizes.length > 0 && valueOfLi[2] == undefined) {
                                productFilterList = searchProductSize(productList, valueOfLi[1]);
                            } else if (
                                valueSizes.length == 0 ||
                                (valueOfLi[1] == undefined && valueOfLi[2] != undefined)
                            ) {
                                productFilterList = searchProductPrice(productList, valueOfLi[2]);
                            } else {
                                productFilterList = searchProductSizePrice(
                                    productList,
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
                            productFilterList = searchProductSize(productList, valueOfLi[1]);
                        } else if (valueOfLi[1].length == 0) {
                            if (valueColors.length == 0 && valueOfLi[2] == undefined) {
                                productFilterList = productList;
                            } else if (valueColors.length > 0 && valueOfLi[2] == undefined) {
                                productFilterList = searchProductColor(productList, valueOfLi[0]);
                            } else if (
                                valueColors.length == 0 ||
                                (valueOfLi[0] == undefined && valueOfLi[2] != undefined)
                            ) {
                                productFilterList = searchProductPrice(productList, valueOfLi[2]);
                            } else {
                                productFilterList = searchProductColorPrice(
                                    productList,
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
//Haha
var localKey = 'Products';
var productList = JSON.parse(localStorage.getItem(localKey));
var wrapList = document.querySelector('.collection-list');
var itemFilterList = [];
var productFilterList = [];

function htmlProduct(arrayProduct) {
    if (arrayProduct.length == 0) {
        return `
         <div class="row listProduct-row listProduct-resize listProduct-filter">
            <div class="col-md-12 product-noloop">
               <div class="collection-alert-no">
                  <p>Không tìm thấy kết quả. Vui lòng thử lại!</p>
               </div>
            </div>
         </div>
      `;
    } else {
        const btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
        if (arrayProduct.length > 20) {
            btnLoadMore.style.display = 'inline-block';
        } else btnLoadMore.style.display = 'none';

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

function checkId(product, productlist) {
    let check = true;
    const length = productlist.length;
    for (let i = 0; i < length; i++) {
        if (product._id == productlist[i]._id) {
            check = false;
            break;
        }
    }
    return check;
}

var dataProduct;

if (urlParams.get('collection') !== null) {
    dataProduct = htmlProduct(
        productList.filter((element) => element.shoeTypes.gender === 'Nữ'),
    ).slice(0, 20);
} else {
    dataProduct = htmlProduct(
        productList.filter((element) => element.shoeTypes.gender === 'Nam'),
    ).slice(0, 20);
}

//Hiện sản phẩm
wrapList.innerHTML = dataProduct.join('');

var btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
btnLoadMore.onclick = () => {
    const tempLength = dataProduct.length + 8;
    if (urlParams.get('collection') !== null) {
        dataProduct = htmlProduct(
            productList.filter((element) => element.shoeTypes.gender === 'Nữ'),
        ).slice(0, tempLength);
    } else {
        dataProduct = htmlProduct(
            productList.filter((element) => element.shoeTypes.gender === 'Nam'),
        ).slice(0, tempLength);
    }

    wrapList.innerHTML = dataProduct.join('');
    setTimeout(() => {
        var btnLoadMore = document.querySelector('.collection-loadmore .btn-loadmore');
        if (productList.filter((element) => element.shoeTypes.gender === 'Nam').length > tempLength) {
            console.log('kkk');
            btnLoadMore.style.display = 'inline-block';
        } else btnLoadMore.style.display = 'none';
    });
};

//Drag and drop
const sliderRange = document.querySelector('#slider-range');
const uisliderRange = sliderRange.querySelector('.ui-widget-header');
const uisliderHandles = sliderRange.querySelectorAll('.ui-slider-handle');
var amount = document.querySelector('#amount');
var amountText = document.querySelector('#amount-text');

var isReadytoDrag = false;
var drop = 0; //Biến kiểm tra chọn handle trái hay phải

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

        const width = Math.ceil(uisliderRange.getBoundingClientRect().width);

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
        const left = Math.ceil(sliderRange.getBoundingClientRect().left);
        const uiRight = Math.ceil(uisliderRange.getBoundingClientRect().right);
        const uiLeft = Math.ceil(uisliderRange.getBoundingClientRect().left);

        const width = Math.ceil(uisliderRange.getBoundingClientRect().width);

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
            productFilterList = searchProductPrice(productList, valueOfLi[2]);
        } else if (valueOfLi[0] != undefined || valueOfLi[1] != undefined) {
            productFilterList = searchProductPrice(productFilterList, valueOfLi[2]);
        }
        var dataProduct = htmlProduct(productFilterList);
        if (productFilterList.length > 0) {
            for (let i = 0; i < dataProduct.length; i++) {
                wrapList.innerHTML = dataProduct.join('');
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

//đổi thành số tiền vnđ
function format2(n) {
    return n
        .toFixed(2)
        .replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
        .split('.')[0];
}
