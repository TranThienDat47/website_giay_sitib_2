const btnPlus = document.querySelectorAll(".tang_sl");
const btnMinus = document.querySelectorAll(".giam_sl");
const btnRemove = document.querySelectorAll(".item-remove");
const countQty = document.querySelector("#count_sl");

for (let tempBtn of btnPlus) {
    tempBtn.onclick = (e) => {
        handlePlusQty(e);
    }
}

for (let tempBtn of btnMinus) {
    tempBtn.onclick = (e) => {
        handleMinusQty(e);
    }
}

for (let tempBtn of btnRemove) {
    tempBtn.onclick = (e) => {
        handleRemoveCartDetail(e);
    }
}




// const cart_detail_id = e.target.getAttribute('data-id');
function handlePlusQty(e) {
    const url = '../api/CartAPI.php';
    const productID = e.target.getAttribute('data-product_id');
    const color = e.target.getAttribute('data-color');
    const size = e.target.getAttribute('data-size');

    if (productID && color && size) {
        const params = {
            action: 'plus_qty_cart_detail',
            productID: `${productID}`,
            color: `${color}`,
            quantity: `1`,
            size: `${size}`
        };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(params)
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
                if (data[0]) {
                    location.reload();
                } else {

                    location.reload();
                    alert("Cập nhật số lượng sản phẩm trong giỏ hàng thất bại!");
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
}

function handleMinusQty(e) {
    const url = '../api/CartAPI.php';
    const product_detail_id = e.target.getAttribute('data-product_detail_id');

    if (parseInt(countQty.textContent) === 1) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
            if (product_detail_id) {
                const params = {
                    action: 'minus_qty_cart_detail',
                    product_detail_id: product_detail_id
                };

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(params)
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
                        if (data[0]) {
                            location.reload();
                        } else {
                            location.reload();
                            alert("Cập nhật số lượng sản phẩm trong giỏ hàng thất bại!");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    } else if (parseInt(countQty.textContent) > 1) {
        if (product_detail_id) {
            const params = {
                action: 'minus_qty_cart_detail',
                product_detail_id: product_detail_id
            };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
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
                    if (data[0]) {
                        location.reload();
                    } else {
                        location.reload();
                        alert("Cập nhật số lượng sản phẩm trong giỏ hàng thất bại!");
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }


}

function handleRemoveCartDetail(e) {
    const url = '../api/CartAPI.php';
    const product_detail_id = e.target.parentNode.getAttribute('data-product_detail_id');


    if (product_detail_id && confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {

        const params = {
            action: 'remove_cart_detail',
            product_detail_id: product_detail_id
        };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(params)
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

                if (data[0]) {
                    location.reload();
                } else {
                    location.reload();
                    alert("Xóa sản phẩm trong giỏ hàng thất bại!");
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
}