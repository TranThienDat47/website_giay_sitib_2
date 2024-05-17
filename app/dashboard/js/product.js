import ListProduct from './ProductController.js';
import Product from './ProductModel.js';

const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);



// ListProduct.getProducts().then((data) => {
//     console.log(data);
// })



let curPage = 10;


function ViewProc({
    _id = '',
    img = '',
    name = '',
    color_sizes_qty = [{ color: 'None', detail: [{ size: '-1', qty: -1 }] }],
    qty = '-1',
    price = '-1',
    category = { gender: 'None', type: 'None' },
    status = '',
}) {
    return `
         <tr class="main-dashboard__product-item">
            <td class="main-dashboard__product-item-proc">
               <div>
                  <div class="main-dashboard__product-item-img">
                     <img
                        src="${img}"
                        alt="${name})"
                     />
                  </div>
                  <h4 class="main-dashboard__product-item-title">
                     ${name}
                  </h4>
               </div>
            </td>
            <td class="main-dashboard__product-item-id">
               <p>${_id}</p>
            </td>
            <td class="main-dashboard__product-item-color">
               <p>${color_sizes_qty
            .map((element) => {
                const tempSize_Qty = element.detail
                    .map((element1) => {
                        return `${element1.size} - ${element1.qty}`;
                    })
                    .join(';<br>&emsp;&emsp;&nbsp;');
                return `${element.color} (${tempSize_Qty})`;
            })
            .join(`<br>`)}</p>
            </td>
            <td class="main-dashboard__product-item-qty">
               <p>${qty}</p>
            </td>
            <td class="main-dashboard__product-item-price">
               <p>${price} ₫</p>
            </td>
            <td class="main-dashboard__product-item-type">
               <p>${category.gender + ' - ' + category.type}</p>
            </td>
            <td class="main-dashboard__product-item-control">
               <div>
                    <div class="main-dasboard__product-item-icon main-dashboard__product-item-active-anactive ${status === "Hoạt động" ? "active" : "anactive"}">
                        <i class="fa-regular fa-circle-pause pause"></i>
                        <i class="fa-solid fa-play play"></i>
                    </div>
                    <div
                        class="main-dasboard__product-item-icon main-dasboard__product-item-update"
                    >
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div
                        class="main-dasboard__product-item-icon main-dasboard__product-item-delete"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </div>
               </div>
            </td>
         </tr>
         `;
}

const innerProc = $('.main-dashboard__product-item-wrapper');

const filterViewProc = (listProc) => {
    return listProc
        .map((element, index) => {
            const imgTemp = element.colors.detail[0].imgs.firstImg || '';

            var temp_color_sizes_qty = [];

            element.colors.list.forEach((element1, index1) => {
                temp_color_sizes_qty.push(element.colors.detail[index1])
            });

            return ViewProc({
                _id: element._id,
                img: imgTemp,
                name: element.name,
                color_sizes_qty: temp_color_sizes_qty,
                qty: element.qty,
                price: element.price,
                category: element.shoeTypes,
                status: element.status,
            });
        })
        .join('');
};

async function getCategoryUpdate() {

    const url = '../api/CategoryAPI.php';
    const data = {
        action: 'get_all_category_with_parent'
    };

    await fetch(url, {
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
            $('#category_product_update').innerHTML = data
                .map((element) => {
                    if (element[2]) {
                        return `
                                <option value="${element[0]}">${element[2]} - ${element[1]}</option>
                                `;
                    } else {
                        return `
                        <option value="${element[0]}">${element[1]} - ${element[2]}</option>
                        `;
                    }
                })
                .join('');
        })
        .catch(error => {
            console.error(error);
        });
}

function getCategory() {

    const url = '../api/CategoryAPI.php';
    const data = {
        action: 'get_all_category_with_parent'
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
            $('#category_product').innerHTML = data
                .map((element) => {
                    if (element[2]) {
                        return `
                                <option value="${element[0]}">${element[2]} - ${element[1]}</option>
                                `;
                    } else {
                        return `
                        <option value="${element[0]}">${element[1]} - ${element[2]}</option>
                        `;
                    }
                })
                .join('');
        })
        .catch(error => {
            console.error(error);
        });
}

const btnMainProc = $('.dasboard-product-add');
const btnCancle = $('.dasboard-product-add__form-submit.cancle');
const btnCancleUpdate = $('.dasboard-product-update__form-submit.cancle');
const btnAddWrapper = $('.main-dashboard__product-add');
const formAddProc = $('.dasboard-product-add__form');
const formUpdateProc = $('.dasboard-product-update__form');

function getFormData() {
    let temp_data = new FormData(formAddProc);
    let temp_detail = {};
    for (const [name, value] of temp_data) {
        temp_detail[`${name}`] = `${value}`;
    }
    return temp_detail;
}
const temp_data = getFormData();

function getFormDataUpdate() {
    let temp_data = new FormData(formUpdateProc);
    let temp_detail = {};
    for (const [name, value] of temp_data) {
        temp_detail[`${name}`] = `${value}`;
    }
    return temp_detail;
}

var temp_data_update;

btnAddWrapper.onclick = function () {
    btnMainProc.style.display = 'flex';

    getCategory();
};

btnCancleUpdate.onclick = function () {
    const cur_data = getFormDataUpdate();
    let flag = true;
    for (let element in cur_data) {
        if (cur_data[element] !== temp_data_update[element]) flag = false;
    }

    if (flag) {
        $('.dasboard-product-update').style.display = 'none';
        window.location.reload();
    } else if (confirm('Dữ liệu sẽ không được sao lưu, có muốn rời khỏi?')) {
        $('.dasboard-product-update').style.display = 'none';
        window.location.reload();
    }
};


btnCancle.onclick = function () {
    const cur_data = getFormData();
    let flag = true;
    for (let element in cur_data) {
        if (cur_data[element] !== temp_data[element]) flag = false;
    }

    if (flag) {
        btnMainProc.style.display = 'none';
    } else if (confirm('Dữ liệu sẽ không được sao lưu, có muốn rời khỏi?')) {
        btnMainProc.style.display = 'none';
        location.reload();
    }
};

function ItemColorSize(tempClass = 2, listColor = []) {
    return `
   <div class="dasboard-product-add__color-size-item ${tempClass}">
      <div class='dasboard-product-add__color'>
         ${listColor
            .map(
                (element) => `
                  <div>
                     <input type="radio" name="c_${tempClass}-color" value="${element.color}" id="c_${tempClass}-${element.tempName}">
                     <label class="dashboard__add-color" style="background-color: ${element.tempName};"
                           for="c_${tempClass}-${element.tempName}"></label>
                  </div>
                  `,
            )
            .join('')}
      </div>
      <div class="dasboard-product-add__size">
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-35" value="35" id="s_${tempClass}-size-35">
            <label for="s_${tempClass}-size-35">35</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-36" value="36" id="s_${tempClass}-size-36">
            <label for="s_${tempClass}-size-36">36</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-37" value="37" id="s_${tempClass}-size-37">
            <label for="s_${tempClass}-size-37">37</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-38" value="38" id="s_${tempClass}-size-38">
            <label for="s_${tempClass}-size-38">38</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-39" value="39" id="s_${tempClass}-size-39">
            <label for="s_${tempClass}-size-39">39</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-40" value="40" id="s_${tempClass}-size-40">
            <label for="s_${tempClass}-size-40">40</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-41" value="41" id="s_${tempClass}-size-41">
            <label for="s_${tempClass}-size-41">41</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-42" value="42" id="s_${tempClass}-size-42">
            <label for="s_${tempClass}-size-42">42</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-43" value="43" id="s_${tempClass}-size-43">
            <label for="s_${tempClass}-size-43">43</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-44" value="44" id="s_${tempClass}-size-44">
            <label for="s_${tempClass}-size-44">44</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-45" value="45" id="s_${tempClass}-size-45">
            <label for="s_${tempClass}-size-45">45</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
         <div>
            <input class="dashboard__add-size" type="checkbox" name="s_${tempClass}-size-46" value="46" id="s_${tempClass}-size-46">
            <label for="s_${tempClass}-size-46">46</label>
            <input
               type="number"
               min="1"
               max="10000"
               class="dasboard-product-add__size-qty"
               value="0"
               readonly
            />
         </div>
      </div>
      <div class="dasboard-product-add__imgs">
         <label for="img_${tempClass}-first_img">Ảnh chính:</label>
         <input
            type="text"
            name="img_${tempClass}-first_img"
            id="img_${tempClass}-first_img"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
         <label for="img_${tempClass}-second_img">Ảnh phụ:</label>
         <input
            type="text"
            name="img_${tempClass}-second_img"
            id="img_${tempClass}-second_img"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
         <label>Ảnh khác (tối đa 4 ảnh):</label>
         <input
            type="text"
            name="img_${tempClass}-orther_1"
            id="img_${tempClass}-orther_1"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
         <input
            type="text"
            name="img_${tempClass}-orther_2"
            id="img_${tempClass}-orther_2"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
         <input
            type="text"
            name="img_${tempClass}-orther_3"
            id="img_${tempClass}-orther_3"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
         <input
            type="text"
            name="img_${tempClass}-orther_4"
            id="img_${tempClass}-orther_4"
            value=""
            placeholder="Nhập đường dẩn ảnh..."
         />
      </div>
   </div>
   `;
}

const btnAddListColorSize = $('#btnAddColor_Size');
const listColorSize = $('.dasboard-product-add__color-size-list');

let tempClassItemColorSize = 2;
let templistColor = [];
let tempCheckSize = [];
let tempFirstImg = [];
let tempSecondImg = [];
let tempOther_1_Img = [];
let tempOther_2_Img = [];
let tempOther_3_Img = [];
let tempOther_4_Img = [];

function handleSizeCheck() {
    const listCheckSize = $$('.dashboard__add-size');
    for (let i of listCheckSize) {
        i.onclick = function () {
            if (i.checked == true) {
                i.parentNode.children[2].style.display = 'block';
            } else {
                i.parentNode.children[2].style.display = 'none';
            }
        };
    }
}

handleSizeCheck();

let tempError = false;

let countSize = 0;
btnAddListColorSize.onclick = function () {
    const lengthColor = listColorSize.children.length;

    const data = new FormData($('.dasboard-product-add__form'));
    var detail = {};
    for (const [name, value] of data) {
        detail[`${name}`] = `${value}`;

        const tempFlagColor = templistColor.find((temp) => temp.tempName === name);
        if (name.indexOf('-color') > 0 && !tempFlagColor) {
            templistColor.push({ tempName: name, color: value });
        }

        const tempFlagFirstImg = tempFirstImg.find((temp) => temp.tempName === name);
        if (name.indexOf('-first_img') > 0 && !tempFlagFirstImg) {
            tempFirstImg.push({ tempName: name, img: value });
        }

        const tempFlagSecondImg = tempSecondImg.find((temp) => temp.tempName === name);
        if (name.indexOf('-second_img') > 0 && !tempFlagSecondImg) {
            tempSecondImg.push({ tempName: name, img: value });
        }

        const tempFlagOther_1_Img = tempOther_1_Img.find((temp) => temp.tempName === name);
        if (name.indexOf('-orther_1') > 0 && !tempFlagOther_1_Img) {
            tempOther_1_Img.push({ tempName: name, img: value });
        }
        const tempFlagOther_2_Img = tempOther_2_Img.find((temp) => temp.tempName === name);
        if (name.indexOf('-orther_2') > 0 && !tempFlagOther_2_Img) {
            tempOther_2_Img.push({ tempName: name, img: value });
        }
        const tempFlagOther_3_Img = tempOther_3_Img.find((temp) => temp.tempName === name);
        if (name.indexOf('-orther_3') > 0 && !tempFlagOther_3_Img) {
            tempOther_3_Img.push({ tempName: name, img: value });
        }
        const tempFlagOther_4_Img = tempOther_4_Img.find((temp) => temp.tempName === name);
        if (name.indexOf('-orther_4') > 0 && !tempFlagOther_4_Img) {
            tempOther_4_Img.push({ tempName: name, img: value });
        }

        let qty = 0;
        const tempFlagSize = tempCheckSize.find((temp) => temp.tempName === name);
        if (name.indexOf('-size') > 0 && !tempFlagSize) {
            const listSize = $$(`input[name=${name}]`);
            for (let i of listSize) {
                if (i.value === value) {
                    qty = i.parentNode.children[2].value;
                }
            }
            tempCheckSize.push({ tempName: name, size: value, qty });
            countSize++;
        }
    }

    if (templistColor.length === tempClassItemColorSize - 1 && countSize > 0) {
        let listColor = [
            { tempName: 'white', color: 'Trắng' },
            { tempName: 'black', color: 'Đen' },
            { tempName: 'green', color: 'Xanh lá' },
            { tempName: 'blue', color: 'Xanh dương' },
            { tempName: 'pink', color: 'Hồng' },
            { tempName: 'grey', color: 'Xám' },
            { tempName: 'yellow', color: 'Vàng' },
            { tempName: 'violet', color: 'Tím' },
        ];

        listColor = listColor.filter((element) => {
            for (let i of templistColor) {
                if (i.color.trim().toLocaleLowerCase() === element.color.trim().toLocaleLowerCase())
                    return false;
            }
            return true;
        });

        if (lengthColor < 7) {
            listColorSize.innerHTML =
                listColorSize.innerHTML + ItemColorSize(tempClassItemColorSize, listColor);
            tempClassItemColorSize++;
            btnAddListColorSize.style.display = 'block';
        } else if (lengthColor === 7) {
            listColorSize.innerHTML =
                listColorSize.innerHTML + ItemColorSize(tempClassItemColorSize, listColor);
            tempClassItemColorSize++;
            btnAddListColorSize.style.display = 'none';
        }

        setTimeout(() => {
            templistColor.forEach((element) => {
                const listColor = $$(`input[name=${element.tempName}]`);
                for (let i of listColor) {
                    if (
                        i.value.trim().toLocaleLowerCase() === element.color.trim().toLocaleLowerCase()
                    ) {
                        i.checked = true;
                    }
                }
            });

            tempFirstImg.forEach((element) => {
                const listFirstImg = $$(`input[name=${element.tempName}]`);
                for (let i of listFirstImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });

            tempSecondImg.forEach((element) => {
                const listSecondImg = $$(`input[name=${element.tempName}]`);
                for (let i of listSecondImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });

            tempOther_1_Img.forEach((element) => {
                const listImg = $$(`input[name=${element.tempName}]`);
                for (let i of listImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });
            tempOther_2_Img.forEach((element) => {
                const listImg = $$(`input[name=${element.tempName}]`);
                for (let i of listImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });
            tempOther_3_Img.forEach((element) => {
                const listImg = $$(`input[name=${element.tempName}]`);
                for (let i of listImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });
            tempOther_4_Img.forEach((element) => {
                const listImg = $$(`input[name=${element.tempName}]`);
                for (let i of listImg) {
                    if (i.name === element.tempName) {
                        i.value = element.img;
                    }
                }
            });


            tempCheckSize.forEach((element) => {
                const listSize = $$(`input[name=${element.tempName}]`);
                for (let i of listSize) {
                    if (i.value.trim().toLocaleLowerCase() === element.size.trim().toLocaleLowerCase()) {
                        i.checked = true;
                        i.parentNode.children[2].value = Number(element.qty);
                    }
                }
            });
            handleSizeCheck();
        });

        countSize = 0;
    } else {
        if (templistColor.length !== tempClassItemColorSize - 1) {
            alert('Dữ liệu không hợp lệ (thiếu màu sắc). Vui lòng nhập lại từ đầu!');
            tempError = true;
            $('.dasboard-product-add__form').reset();
            return;
        } else {
            alert('Dữ liệu không hợp lệ (thiếu kích thước). Vui lòng nhập lại từ đầu!');
            tempError = true;
            $('.dasboard-product-add__form').reset();
            return;
        }
    }
};

const btnAddProcForm = $('#add_proc_form');
const btnUpdateProcForm = $('#update_proc_form');

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

function uniqueSize(arr) {
    var newArr = [];
    for (var i = 0; i < arr.length; i++) {
        let flag = false;
        for (let j = 0; j < newArr.length; j++) {
            if (Number(newArr[j].size) === Number(arr[i].size)) {
                flag = true;
                break;
            }
            flag === false;
        }
        if (flag === false) {
            newArr.push(arr[i]);
        }
    }
    return newArr;
}

function unique(arr) {
    var newArr = [];
    for (var i = 0; i < arr.length; i++) {
        if (newArr.indexOf(arr[i]) === -1) {
            newArr.push(arr[i]);
        }
    }
    return newArr;
}

function ViewDetailProc(img1, img2, img3, img4, img5, img6, color, size, qty, productDetail_id) {

    const listColor = [
        { tempName: 'white', color: 'Trắng' },
        { tempName: 'black', color: 'Đen' },
        { tempName: 'green', color: 'Xanh lá' },
        { tempName: 'blue', color: 'Xanh dương' },
        { tempName: 'pink', color: 'Hồng' },
        { tempName: 'grey', color: 'Xám' },
        { tempName: 'yellow', color: 'Vàng' },
        { tempName: 'violet', color: 'Tím' },
    ];

    const listSize = [
        35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46
    ];


    const temp = listColor.map((element) => {
        if (element.color === color) {
            return `<option selected>${element.color}</option>`;
        } else {
            return `<option>${element.color}</option>`;
        }
    }).join("");

    const tempSize = listSize.map((element) => {
        if (element === parseInt(size)) {

            return `<option selected>${element}</option>`;
        } else {
            return `<option>${element}</option>`;
        }
    }).join("");

    return `
    <tr>
        <td><input class="input_detail_product" type="text" value="${img1}" disabled /></td>
        <td><input class="input_detail_product" type="text" value="${img2}" disabled /></td>
        <td><input class="input_detail_product" type="text" value="${img3}" disabled /></td>
        <td><input class="input_detail_product" type="text" value="${img4}" disabled /></td>
        <td><input class="input_detail_product" type="text" value="${img5}" disabled /></td>
        <td><input class="input_detail_product" type="text" value="${img6}" disabled /></td>
        <td>
            <select disabled id="list_color_update">
                ${temp}
            </select>
        </td>
        <td>
            <select disabled id="list_size_update">
                ${tempSize}
            </select>
        </td>
        <td><input style="width: 100px;" class="input_detail_product" type="text" value="${qty}" disabled /></td>
        <td class="main-dashboard__product-item-control">
            <div>
                <button data-product-detail_id='${productDetail_id}' class="save_detail_product" style="display: none; border: 1px solid green; border-radius: 4px; color: green;" type="button">Lưu</button>
                <div class="update_detail_product" style="color: blue; margin: 0 10px;"
                    class="main-dasboard__product-item-icon ">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
                <div data-id='${productDetail_id}' class="main-dasboard__product-item-icon main-dashboard__product_detail-item-active-anactive ${parseInt(qty) > 0 ? "active" : "anactive"}">
                        <i class="fa-regular fa-circle-pause pause"></i>
                        <i class="fa-solid fa-play play"></i>
                    </div>
                <div data-id='${productDetail_id}' data-qty = '${qty}' class="delete_detail_product" style="color: red;"
                    class="main-dasboard__product-item-icon ">
                    <i class="fa-regular fa-trash-can"></i>
                </div>
            </div>
        </td>
    </tr>
    `;
}

var id_add_product_detail = 0;


function ViewDetailProcAdd(listUsedColorSize) {
    const listSize = [
        35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46
    ];

    const listColor = [
        'Trắng',
        'Đen',
        'Xanh lá',
        'Xanh dương',
        'Hồng',
        'Xám',
        'Vàng',
        'Tím',
    ];

    const templistColor = listColor.filter((element) => {
        const curColorAndSize = listUsedColorSize.find((tempColorAndSize) => (tempColorAndSize.color === element))

        if (curColorAndSize && curColorAndSize.size.length >= listSize.length) {
            return false;
        }
        return true;
    })

    const tempColor = templistColor.map((element) => {
        return `<option>${element}</option>`;
    }).join("");

    setTimeout(() => {

        const selectedSize = $(`.id_add_product_detail-size_${id_add_product_detail}`);
        const selectedColor = $(`.id_add_product_detail-color_${id_add_product_detail}`);

        selectedColor.onchange = () => {

            const listSizeTemp = listUsedColorSize.find((colorList) => {
                return colorList.color === selectedColor.value;
            })
            if (!listSizeTemp) {
                selectedSize.innerHTML = listSize.map((listSize) => (`<option>${listSize}</option>`)).join("");
            } else {


                const newListSize = listSize.filter((element) => !listSizeTemp.size.includes(`${element}`));

                selectedSize.innerHTML = newListSize.map((listSize) => (`<option>${listSize}</option>`)).join("");
            }
        }

        setTimeout(() => {

            id_add_product_detail++;
        })

    })

    return `
    <tr>
        <td><input autofocus style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td><input style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td><input style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td><input style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td><input style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td><input style="border: 1px solid #999;" class="input_detail_product" type="text" value=""  /></td>
        <td>
            <select class="id_add_product_detail-color_${id_add_product_detail}" style="border: 1px solid #999;" id="list_color_update">
                <option value="-1">Màu sắc</option>
                ${tempColor}
            </select>
        </td>
        <td>
            <select class="id_add_product_detail-size_${id_add_product_detail}" style="border: 1px solid #999;" id="list_size_update">
            </select>
        </td>
        <td><input disabled style="width: 100px;" class="input_detail_product" type="text" value="0"  /></td>
        <td class="main-dashboard__product-item-control">
            <div>
                <button class="save_add_detail_product_${id_add_product_detail}" style="border: 1px solid green; border-radius: 4px; color: green;" type="button">Lưu</button>
            </div>
        </td>
    </tr>
    `;
}

async function addProductDetail(product_id, productDetail) {
    const img1 = productDetail.img1, img2 = productDetail.img2, img3 = productDetail.img3, img4 = productDetail.img4, img5 = productDetail.img5, img6 = productDetail.img6, color = productDetail.color, size = productDetail.size;

    const url = '../api/ProductAPI.php';
    const data = {
        action: 'add_product_detail',
        product_id,
        img1,
        img2,
        img3,
        img4,
        img5,
        img6,
        color,
        size,
    };


    await fetch(url, {
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
            console.log("result - ", data);
        })
        .catch(error => {
            console.error(error);
        });
}

async function updateProductDetail(productDetail) {
    const productDetail_id = productDetail.productDetail_id, img1 = productDetail.img1, img2 = productDetail.img2, img3 = productDetail.img3, img4 = productDetail.img4, img5 = productDetail.img5, img6 = productDetail.img6, color = productDetail.color, size = productDetail.size;

    const url = '../api/ProductAPI.php';
    const data = {
        action: 'update_product_detail',
        productDetail_id,
        img1,
        img2,
        img3,
        img4,
        img5,
        img6,
        color,
        size,
    };

    const response = await fetch(url, {
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
            if (data) {
                alert("Cập nhật chi tiết thành công!");
                return true;
            } else {
                return false;
            }
        })
        .catch(error => {
            console.error(error);
        });


    const result = await response;

    return result;
}

function updateProduct(_id, name, description, price, category_id) {

    const product_id = _id;

    const url = '../api/ProductAPI.php';
    const data = {
        action: 'update_product',
        product_id,
        name,
        description,
        price,
        category_id
    };

    console.log(data);

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
        .then((data) => {
            if (data) {
                window.location.href = "./DB_Product.php"
            }
        })
        .catch(error => {
            console.error(error);
        });
}


function handleUpdate(listProductReal) {
    const listUpdate = $$('.main-dasboard__product-item-update');
    for (let i = 0; i < listUpdate.length; i++) {

        listUpdate[i].onclick = () => {

            var defaultName, defaultDescription, defaultPrice, defaultCategory;

            $(".dasboard-product-update").style.display = 'flex';
            var btnupdate_detail, btnsave_detail;

            setTimeout(() => {
                btnupdate_detail = $$('.update_detail_product');
                for (let tempBtn of btnupdate_detail) {
                    tempBtn.onclick = () => {

                        const inputImg1 = tempBtn.parentNode.parentNode.parentNode.children[0].children[0];
                        const inputImg2 = tempBtn.parentNode.parentNode.parentNode.children[1].children[0];
                        const inputImg3 = tempBtn.parentNode.parentNode.parentNode.children[2].children[0];
                        const inputImg4 = tempBtn.parentNode.parentNode.parentNode.children[3].children[0];
                        const inputImg5 = tempBtn.parentNode.parentNode.parentNode.children[4].children[0];
                        const inputImg6 = tempBtn.parentNode.parentNode.parentNode.children[5].children[0];
                        const color = tempBtn.parentNode.parentNode.parentNode.children[6].children[0];
                        const size = tempBtn.parentNode.parentNode.parentNode.children[7].children[0];
                        const btnSave = tempBtn.parentNode.parentNode.parentNode.children[9].children[0].children[0];

                        if (inputImg1.value === "" && inputImg2.value === "") {

                        } else {
                            inputImg1.disabled = false;
                            inputImg2.disabled = false;
                            inputImg3.disabled = false;
                            inputImg4.disabled = false;
                            inputImg5.disabled = false;
                            inputImg6.disabled = false;

                            inputImg1.style.border = "1px solid #999";
                            inputImg2.style.border = "1px solid #999";
                            inputImg3.style.border = "1px solid #999";
                            inputImg4.style.border = "1px solid #999";
                            inputImg5.style.border = "1px solid #999";
                            inputImg6.style.border = "1px solid #999";

                            btnSave.style.display = "block";

                        }

                        const defauColor = color.value;


                        setTimeout(() => {
                            const selectColor = color;

                            selectColor.onchange = () => {
                                if (defauColor !== selectColor.value) {
                                    inputImg1.disabled = false;
                                    inputImg2.disabled = false;
                                    inputImg3.disabled = false;
                                    inputImg4.disabled = false;
                                    inputImg5.disabled = false;
                                    inputImg6.disabled = false;

                                    inputImg1.style.border = "1px solid #999";
                                    inputImg2.style.border = "1px solid #999";
                                    inputImg3.style.border = "1px solid #999";
                                    inputImg4.style.border = "1px solid #999";
                                    inputImg5.style.border = "1px solid #999";
                                    inputImg6.style.border = "1px solid #999";

                                    inputImg1.focus();
                                }
                            }
                        })

                        inputImg1.focus();
                        setTimeout(() => {
                            btnsave_detail = $$('.save_detail_product');
                            for (let tempBtn of btnsave_detail) {
                                tempBtn.onclick = () => {

                                    if (inputImg1.value === "" || inputImg2.value === "") {
                                        alert("Bạn phải điền 'Img1' và 'Img2' ")
                                        return;
                                    }

                                    const productdetail = {
                                        img1: inputImg1.value, img2: inputImg2.value,
                                        img3: inputImg3.value, img4: inputImg4.value, img5: inputImg5.value,
                                        img6: inputImg6.value, color: color.value, size: size.value, productDetail_id: tempBtn.getAttribute("data-product-detail_id")
                                    };

                                    updateProductDetail(productdetail).then(() => {
                                        inputImg1.disabled = true;
                                        inputImg2.disabled = true;
                                        inputImg3.disabled = true;
                                        inputImg4.disabled = true;
                                        inputImg5.disabled = true;
                                        inputImg6.disabled = true;

                                        inputImg1.style.border = "none";
                                        inputImg2.style.border = "none";
                                        inputImg3.style.border = "none";
                                        inputImg4.style.border = "none";
                                        inputImg5.style.border = "none";
                                        inputImg6.style.border = "none";

                                        btnSave.style.display = "none";

                                    });

                                }
                            }
                        })
                    }
                }

                btnUpdateProcForm.onclick = () => {
                    if (defaultCategory !== $("#category_product_update").value || defaultName !== $("#name_product_update").value ||
                        defaultDescription !== $("#description_product_update").value || defaultPrice !== $("#price_product_update").value
                    ) {
                        updateProduct(tempProc._id, $("#name_product_update").value, $("#description_product_update").value, $("#price_product_update").value, $("#category_product_update").value);
                    } else {
                        alert("Dữ liệu không có gì thay đổi.")
                    }
                }
            })

            const tempProc = listProductReal[i];

            $('.dasboard-product-add__wrapper-text').style.display = "flex";
            $('#id_product_update').value = tempProc._id;
            $('#name_product_update').value = tempProc.name;

            defaultName = tempProc.name;

            $('#description_product_update').value = tempProc.description;

            defaultDescription = tempProc.description;

            $('#price_product_update').value = Number(tempProc.price.replaceAll(',', ''));

            defaultPrice = (tempProc.price.replaceAll(',', ''));



            getCategoryUpdate().then(() => {
                setTimeout(() => {
                    temp_data_update = getFormDataUpdate();
                    defaultCategory = $("#category_product_update").value;

                })
            });

            var listUsedColorSize = [];

            var innerProductDetailUpdate = "";
            tempProc.colors.detail.forEach((element, index) => {
                var tempColor = null;
                listUsedColorSize.push({ color: element.color, size: [] });

                element.detail.forEach((element1) => {

                    const productdetail = {
                        img1: element.imgs.firstImg, img2: element.imgs.secondeImg,
                        img3: element.imgs.orthers[0] || "", img4: element.imgs.orthers[1] || "", img5: element.imgs.orthers[2] || "",
                        img6: element.imgs.orthers[3] || "", color: element.color, size: element1.size, productDetail_id: element1.productDetail_id
                    };

                    listUsedColorSize[index].size.push(element1.size);

                    if (!tempColor) {
                        innerProductDetailUpdate += ViewDetailProc(productdetail.img1, productdetail.img2, productdetail.img3, productdetail.img4, productdetail.img5, productdetail.img6, productdetail.color, productdetail.size, element1.qty, element1.productDetail_id);
                        tempColor = element.color;
                    }
                    else {
                        innerProductDetailUpdate += ViewDetailProc("", "", "", "", "", "", productdetail.color, productdetail.size, element1.qty, element1.productDetail_id);
                    }


                })

            })

            $('#main_innerProductDetailUpdate').innerHTML = innerProductDetailUpdate;

            setTimeout(() => {
                const btn_add_product_detail = $('#btn_add_product_detail');
                const btn_delete_product_detail = $$('.delete_detail_product');
                const btn_anactive_product_detail = $$('.main-dashboard__product_detail-item-active-anactive');

                for (let i = 0; i < btn_delete_product_detail.length; i++) {
                    btn_delete_product_detail[i].onclick = () => {
                        const tempText = prompt('Nhập "Ok" để đồng ý xoá!');
                        if (tempText === 'Ok') {
                            window.location.href = `./DB_Product.php?action=delete_product_detail&product_detail_id=${btn_delete_product_detail[i].getAttribute('data-id')}&product_detail_qty=${btn_delete_product_detail[i].getAttribute('data-qty')}`;
                        } else if (tempText === null) {
                        } else {
                            alert('Xoá sản phẩm thất bại!');
                        }
                    }
                }

                for (let i = 0; i < btn_anactive_product_detail.length; i++) {
                    btn_anactive_product_detail[i].onclick = () => {
                        if (btn_anactive_product_detail[i].classList.contains('active')) {
                            const tempText = prompt('Nhập "Ok" để ngưng hoạt động sản phẩm này!');
                            if (tempText === 'Ok') {
                                window.location.href = `./DB_Product.php?action=delete_product_detail&product_detail_id=${btn_anactive_product_detail[i].getAttribute('data-id')}`;
                            } else if (tempText === null) {
                            } else {
                                alert('Thao tác thất bại!');
                            }
                        }
                    }
                }

                btn_add_product_detail.onclick = () => {
                    if (true) {
                        btn_add_product_detail.disabled = true;
                        btn_add_product_detail.classList.add('disable_btn');

                        const tempAddInner = ViewDetailProcAdd(listUsedColorSize);

                        innerProductDetailUpdate += tempAddInner;
                        $('#main_innerProductDetailUpdate').innerHTML = innerProductDetailUpdate;

                        setTimeout(() => {
                            const btn_add_detail = $(`.save_add_detail_product_${id_add_product_detail}`);

                            btn_add_detail.onclick = () => {

                                const inputImg1 = btn_add_detail.parentNode.parentNode.parentNode.children[0].children[0];
                                const inputImg2 = btn_add_detail.parentNode.parentNode.parentNode.children[1].children[0];
                                const inputImg3 = btn_add_detail.parentNode.parentNode.parentNode.children[2].children[0];
                                const inputImg4 = btn_add_detail.parentNode.parentNode.parentNode.children[3].children[0];
                                const inputImg5 = btn_add_detail.parentNode.parentNode.parentNode.children[4].children[0];
                                const inputImg6 = btn_add_detail.parentNode.parentNode.parentNode.children[5].children[0];
                                const color = btn_add_detail.parentNode.parentNode.parentNode.children[6].children[0];
                                const size = btn_add_detail.parentNode.parentNode.parentNode.children[7].children[0];

                                const productdetail = {
                                    img1: inputImg1.value, img2: inputImg2.value,
                                    img3: inputImg3.value, img4: inputImg4.value, img5: inputImg5.value,
                                    img6: inputImg6.value, color: color.value, size: size.value
                                };

                                addProductDetail(tempProc._id, productdetail).then(() => {
                                    window.location.reload();
                                });

                            }
                        })
                    }

                }


            })
        };
    }
}


function handleUpload() {

    btnAddProcForm.onclick = function () {
        tempError = false;
        const data = new FormData($('.dasboard-product-add__form'));
        var dataDetail = {};

        let tempColor = [];
        for (const [name, value] of data) {
            if (name.includes('-color')) {
                if (tempColor.includes(value)) {
                    alert('Màu sắc không thể trùng nhau. Vui lòng thao tác lại!');
                    return;
                }
                tempColor.push(value);
            }
            dataDetail[`${name}`] = `${value}`;
        }

        btnAddListColorSize.onclick();

        if (tempError) {
            return;
        }

        let listSize = tempCheckSize.map((element) => element.size);
        listSize = unique(listSize);

        const listColor = templistColor.map((element) => element.color);
        let i = -1;
        const qty = tempCheckSize.reduce(
            (previousValue, currentValue) => Number(Number(previousValue) + Number(currentValue.qty)),
            0,
        );
        const detail = templistColor.map((element) => {
            i++;
            let detailNew = [];
            let detailTemp = tempCheckSize.map((element1) => {
                if (Number(element.tempName[2]) === Number(element1.tempName[2])) {
                    return {
                        size: element1.size,
                        qty: element1.qty,
                    };
                }
                return;
            });

            detailTemp.forEach((elementSize) => {
                if (elementSize) {
                    detailNew.push(elementSize);
                }
            });

            detailNew = uniqueSize(detailNew);

            const listOther = [];

            const tenpListOther = [
                tempOther_1_Img[i].img || '',
                tempOther_2_Img[i].img || '',
                tempOther_3_Img[i].img || '',
                tempOther_4_Img[i].img || '',
            ];

            tenpListOther.forEach((elementOther) => {
                if (elementOther.trim() !== '') {
                    listOther.push(elementOther);
                }
            });

            const sl = tempCheckSize.reduce((previousValue, currentValue) => {
                if (Number(element.tempName[2]) === Number(currentValue.tempName[2])) {
                    return Number(Number(previousValue) + Number(currentValue.qty));
                }
                return Number(previousValue);
            }, 0);

            return {
                color: element.color,
                imgs: {
                    firstImg: tempFirstImg[i].img || '',
                    secondeImg: tempSecondImg[i].img || '',
                    orthers: listOther,
                },
                qty: sl,
                detail: detailNew,
            };
        });
        setTimeout(() => {
            ListProduct.add(
                new Product(
                    $('#id_product').value,
                    dataDetail.name_product,
                    dataDetail.description_product,
                    numberMoney(dataDetail.price_product.toString())[0] !== ','
                        ? numberMoney(dataDetail.price_product.toString())
                        : numberMoney(dataDetail.price_product.toString()).replace(',', ''),
                    qty,
                    true,
                    {
                        gender: $('#category_product').value,
                        type: $('#category_product').options[$('#category_product').selectedIndex].text,
                    },
                    listSize,
                    {
                        list: listColor,
                        detail,
                    },
                    0,
                ),
            );
        }, 100)
    };
}

setTimeout(() => {
    handleUpload();
}, 1000);

function handleDel(listProduct) {
    const btnDel = $$('.main-dasboard__product-item-delete');

    for (let i = 0; i < btnDel.length; i++) {
        btnDel[i].onclick = function () {
            const parrentElement = btnDel[i].parentNode.parentNode.parentNode.children[1];
            const tempText = prompt('Nhập "Ok" để đồng ý xoá!');
            if (tempText === 'Ok') {
                console.log(listProduct[i]._id);
                window.location.href = `./DB_Product.php?action=delete_product&product_id=${listProduct[i]._id}`;
            } else if (tempText === null) {
            } else {
                alert('Xoá sản phẩm thất bại!');
            }
        };
    }
}

function handleStatus(listProduct) {
    const btnStatus = $$('.main-dashboard__product-item-active-anactive');
    for (let i = 0; i < btnStatus.length; i++) {
        btnStatus[i].onclick = function () {
            if (
                btnStatus[i].classList.contains('anactive') &&
                confirm('Bạn có muốn đưa sản phẩm vào hoạt động?')
            ) {
                btnStatus[i].classList.remove('anactive');
                btnStatus[i].classList.add('active');
                console.log(listProduct[i]);

                window.location.href = `./DB_Product.php?action=update_status_product&product_id=${listProduct[i]._id}&new_status=${encodeURIComponent('Hoạt động')}`;

            } else if (
                btnStatus[i].classList.contains('active') &&
                confirm('Bạn có muốn tạm dừng bán sản phẩm?')
            ) {
                btnStatus[i].classList.remove('active');
                btnStatus[i].classList.add('anactive');

                window.location.href = `./DB_Product.php?action=update_status_product&product_id=${listProduct[i]._id}&new_status=${encodeURIComponent('Tạm dừng')}`;

            }
        };
    }
}



ListProduct.getProducts().then((data) => {
    innerProc.innerHTML = filterViewProc(data.slice(0, curPage));

    const btnMore = $('#nextPageWishList');

    if (data.length > curPage) btnMore.style.display = 'flex';
    setTimeout(() => {
        handleUpdate(data);
        handleDel(data);
        handleStatus(data);
    }, 100)


    btnMore.onclick = function () {
        curPage += 10;

        if (data.length <= curPage) {
            btnMore.style.display = 'none';
            curPage = data.length;
        }
        innerProc.innerHTML = filterViewProc(data.slice(0, curPage));
        setTimeout(() => {
            handleUpdate(data);
            handleDel(data);
            handleStatus(data);
        }, 100)
    };

    const inputSearch = $('.main-dashboard__product-handle-search > input')
    const categorySearch = $('.main-dashboard__product-handle-filter')

    categorySearch.onchange = () => {
        if (categorySearch.value !== 'no') {

            const newData = data.filter((element) => {

                var keySearch = element.shoeTypes.type;
                if (element.shoeTypes.type) {
                    keySearch = element.shoeTypes.type + " - " + element.shoeTypes.gender;
                } else {
                    keySearch = element.shoeTypes.gender + " - null";
                }
                return keySearch === categorySearch.value;
            })
            innerProc.innerHTML = filterViewProc(newData);
            setTimeout(() => {
                handleUpdate(newData);
                handleDel(newData);
                handleStatus(newData);
            }, 100)
        } else {
            curPage = 10;
            innerProc.innerHTML = filterViewProc(data.slice(0, curPage));
            setTimeout(() => {
                handleUpdate(data);
                handleDel(data);
                handleStatus(data);
            }, 100)
        }
    }

    function debounceSearch(callback, delay) {
        let timerId;

        return function () {
            const context = this;
            const args = arguments;

            clearTimeout(timerId);

            timerId = setTimeout(() => {
                callback.apply(context, args);
            }, delay);
        }
    }

    function search() {
        if (inputSearch.value.trim() !== "") {
            const newData = data.filter((element) => {
                const keySearch = element.name + " " + element._id + " " + element.status + " " + element.price;
                if (keySearch.toLowerCase().includes(inputSearch.value)) {
                    return true;
                } else {
                    return false;
                }
            })
            innerProc.innerHTML = filterViewProc(newData);
            setTimeout(() => {
                handleUpdate(newData);
                handleDel(newData);
                handleStatus(newData);
            }, 100)
        } else {
            curPage = 10;
            innerProc.innerHTML = filterViewProc(data.slice(0, curPage));
            setTimeout(() => {
                handleUpdate(data);
                handleDel(data);
                handleStatus(data);
            }, 100)
        }
    }

    const debounceSearchReal = debounceSearch(search, 500);

    inputSearch.addEventListener('input', debounceSearchReal);


})



