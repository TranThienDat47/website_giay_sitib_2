// import { showItemWishList } from '../WishList/index.js';

function Product({
    _id = '',
    name = '',
    price = '',
    color = {},
    sizes = [],
    promotional_price = '',
    promotion_percentage = '',
    news = false,
}) {
    setTimeout(() => {
        // showItemWishList();
    });

    return `
    <div class="product-wrapper col-4">
        <div data-id="${_id}" class="product-inner collection product-lists-item">
            <div class="product-box-img">
                <div class="product-favorite onwishlist_btn_add" data-id="${_id}" data-price="${price}"
                    data-title="${name}"
                    data-img="${color.list && color.detail[0] ? color.detail[0].imgs.firstImg : ''
        }">
                    <svg class="svg-ico-wishlist" xmlns="http://www.w3.org/2000/svg" version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                        width="512" height="512" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <g xmlns="http://www.w3.org/2000/svg" id="_1_Heart" data-name="1 Heart">
                                <path
                                    d="m256.1 506a25 25 0 0 1 -17.68-7.35l-.2-.2-197.55-197.45c-54.12-54.13-54.12-142.2 0-196.33s142.2-54.12 196.33 0l19.1 19.1 18.9-18.9a138.83 138.83 0 0 1 196.33 0c54.12 54.13 54.12 142.2 0 196.33l-81.22 81.21a25 25 0 0 1 -35.35-35.41l81.24-81.2a88.82 88.82 0 0 0 -125.64-125.61l-36.58 36.58a25 25 0 0 1 -35.36 0l-36.78-36.77a88.82 88.82 0 0 0 -125.64 125.6l180.1 180.07 19.13-19.13a25 25 0 0 1 35.36 35.35l-36.81 36.82a25 25 0 0 1 -17.68 7.29z"
                                    fill="#000000" data-original="#000000" class=""></path>
                            </g>
                        </g>
                    </svg>
                </div>
                ${news
            ? `<div class="product-label">
                        <div class="pro-new">Mới</div>
                        <div class="pro-gift"><img alt=""
                            src="https://file.hstatic.net/1000230642/file/gift_05b25b51e07e421ab8b2ea2969b017bc.png"
                            onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                            >
                        </div>
                    </div>`
            : ``
        }
                <div class="product-boxImg-inner">
                    <div class="product-boxImg-flex">
                        <a href="./product.php?id=${_id}">
                            <div class="prod-img first-image">
                                <picture style="width: 100%;">
                                    <img class="img-loop ls-is-cached lazyloaded"
                                        data-src="${color.list ? color.detail[0].imgs.firstImg : ''
        }"
                                        src="${color.list ? color.detail[0].imgs.firstImg : ''}"
                                        alt="${name} (${color.list ? color.list[0] : ''}) "
                                        onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                                        >
                                </picture>
                            </div>
                            <div class="prod-img second-image">
                                <picture style="width: 100%;">
                                    <img class="img-loop ls-is-cached lazyloaded"
                                        data-src="${color.list ? color.detail[0].imgs.secondeImg : ''
        }"
                                        src="${color.list ? color.detail[0].imgs.secondeImg : ''}"
                                        alt="${name} (${color.list ? color.list[0] : ''}) "
                                        onerror="this.onerror=null;this.src='https://developers.google.com/static/maps/documentation/maps-static/images/error-image-generic.png';"
                                        >
                                </picture>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="product-box-info">
                <div class="product-box-variable d-flex align-items-center justify-content-between">
                    <div class="box-number-size">
                        +${sizes.length} size
                    </div>
                    <div class="box-number-color">
                        + ${color.list ? color.list.length : ''} Màu sắc
                    </div>
                </div>
                <div class="product-box-title">
                    <h4>
                        <a
                            href="./product.php?id=${_id}">${name}
                            (${color.list ? color.list[0] : ''})</a>
                    </h4>
                </div>
                <div class="product-box-price d-flex align-items-center">
                    ${Number(promotion_percentage) > 0
            ? `<div class="main-price-sale">
                                <span class="main-price-inner">${promotional_price} ₫</span>
                            </div>
                            <del class="main-price-del">${price} ₫</del>
                            <span class="sale-price-discount">-${promotion_percentage}%</span>`
            : `
                            <div class="main-price-del">${price} ₫</div>
                            `
        }
                </div>
                <div class="product-swatch-loop d-flex flex-wrap align-items-center justify-content-center">
                    <div data-swatch="color"
                        class="w-100 swatch-loop-item d-flex align-items-center justify-content-center flex-wrap">
                        ${color.list && color.list.length > 1
            ? color.detail
                .map((element, index) => {
                    if (index != 0)
                        return `
                                 <span data-color="${color.list[0]}"
                                 style="background: url(${element.imgs.firstImg}) !important;background-size: contain !important;"
                                 data-img-first="${element.imgs.firstImg}"
                                 data-img-second="${element.imgs.secondeImg}"
                                 class="item-color"></span>
                                 `;
                    else
                        return `
                                 <span data-color="${color.list[0]}"
                                 style="background: url(${element.imgs.firstImg}) !important;background-size: contain !important;"
                                 data-img-first="${element.imgs.firstImg}"
                                 data-img-second="${element.imgs.secondeImg}"
                                 class="item-color active"></span>
                                 `;
                })
                .join('')
            : ''
        }
                        
                    </div>
                    <div class="product-action">
                        <a href="./product.php?id=${_id}">
                            <button class="add-to-cart-loop">
                                Mua ngay 
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
}

export default Product;