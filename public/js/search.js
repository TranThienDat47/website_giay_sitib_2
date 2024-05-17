const $ = document.querySelector.bind(document);

import Product from './productItem.js';
import ListProduct from './ProductController.js';

const listSearchResults = $('.searchPage__listProduct-row');
const txtValueSearch = $('.searchPage__subtext-result > strong');
const txtCountSearch = $('.searchPage__subtxt > strong');
const txtNoSearch = $('#searchPage__pagination');
const btnMoreSearch = $('#nextPageSearch');
const btnTempSearch = $('#tempPageSearch');

const urlParams = new URLSearchParams(window.location.search);

txtValueSearch.innerHTML = `"${urlParams.get('value').trim()}"`;
const SIZE_PAGE = 8;
let tempPage = SIZE_PAGE;

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

async function showMoreSearch() {
    let data = await ListProduct.findAll(urlParams.get('value')) || [];

    btnMoreSearch.onclick = function () {
        tempPage += SIZE_PAGE;
        showMoreSearch();
        btnTempSearch.click();
    };

    txtCountSearch.innerHTML = `${data.length} sản phẩm`;

    if (data.length === 0) txtNoSearch.innerHTML = 'Không thấy kết quả cần tìm kiếm!';

    if (data.length > SIZE_PAGE) {
        if (data.length - tempPage > 0) {
            btnMoreSearch.style.display = 'inline-block';
        } else {
            btnMoreSearch.style.display = 'none';
            tempPage = data.length;
        }
    } else btnMoreSearch.style.display = 'none';

    listSearchResults.innerHTML = data
        .map((element) => {
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
        })
        .slice(0, tempPage)
        .join('');
}

function checkKeySearch() {
    if (urlParams.get('value').trim() !== '') {
        showMoreSearch();
    } else {
        txtNoSearch.innerHTML = 'Không thấy kết quả cần tìm kiếm!';
        $('.searchPage__subtext-result').innerHTML = '';
    }
}

checkKeySearch();