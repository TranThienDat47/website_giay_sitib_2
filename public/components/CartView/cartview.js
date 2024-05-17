const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

function CartView({ namePro, linkTo, img, color, size, price }) {
   return `
        <table id="cart-view">
            <tbody>
                <tr data-promotion="false" class="mini-cart__item">
                    <td class="mini-cart__left">
                        <a class="mnc-link"
                            href="${linkTo}">
                              <img src="${img}"
                                alt="${namePro + '(' + color + ')'}"
                                onerror="this.onerror=null;this.src='../../access/img/error-image-generic.png';"
                                >
                        </a>
                    </td>
                    <td class="mini-cart__right">
                        <p class="mini-cart__title">
                            <a class="mnc-title mnc-link"
                                href="${linkTo}"
                                title="${namePro + '(' + color + ')'}"
                            >
                                ${namePro + '(' + color + ')'}
                            </a>
                            <span class="mnc-variant">
                               ${color + '/' + size}
                            </span>
                        </p>
                        <div class="mini-cart__quantity">
                            <button class="qty-btn mnc-minus">-</button>
                            <input class="qty-value" type="text"
                                name="mnc-quantity"
                                readonly
                                value="1">
                            <button class="qty-btn mnc-plus">+</button>
                        </div>
                        <div class="mini-cart__price">
                            <span class="mnc-price">${price} ₫</span>
                            <del class="mnc-ori-price"></del>
                        </div>
                        <div class="mini-cart__remove">
                           <i class="fa-solid fa-xmark"></i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    `;
}

import ListCart from '../../app/controllers/CartController.js';
let btnRemoveCart, btnQtyPlus, btnQtyMinus, inputQty, priceProduc;

function eventCarts() {
   setTimeout(() => {
      btnRemoveCart = $$('.mini-cart__remove');
      btnQtyMinus = $$('.mini-cart__quantity .qty-btn.mnc-minus');
      btnQtyPlus = $$('.mini-cart__quantity .qty-btn.mnc-plus');
      inputQty = $$('.mini-cart__quantity .qty-value');
      priceProduc = $$('.mnc-price');
      const actionCart = $('.header__action-cart .header__action-item-text');

      for (let index = 0; index < btnRemoveCart.length; index++) {
         inputQty[index].value = ListCart.getCarts[index].qty;

         btnQtyMinus[index].onclick = function () {
            if ($('.mini-cart__quantity > input').value - 1 <= 0) {
               if (confirm('Bạn chắc chắc muốn xoá sản phẩm này?')) {
                  ListCart.minusQty(index);
                  if (ListCart.getCarts[index]) {
                     inputQty[index].value = Number(ListCart.getCarts[index].qty);
                  } else {
                     ViewCart();
                  }
                  setTimeout(() => {
                     actionCart.classList.add('show-triangle');
                  }, 0);
                  totalCarts();
               }
            } else {
               ListCart.minusQty(index);
               if (ListCart.getCarts[index]) {
                  inputQty[index].value = Number(ListCart.getCarts[index].qty);
               } else {
                  ViewCart();
               }
               setTimeout(() => {
                  actionCart.classList.add('show-triangle');
               }, 0);
               totalCarts();
            }
         };

         btnQtyPlus[index].onclick = function () {
            ListCart.plusQty(index);
            if (ListCart.getCarts[index]) {
               inputQty[index].value = Number(ListCart.getCarts[index].qty);
            }
            ViewCart();
            setTimeout(() => {
               actionCart.classList.add('show-triangle');
            }, 0);
         };

         btnRemoveCart[index].onclick = function () {
            if (confirm('Bạn chắc chắ muốn xoá sản phẩm này?')) {
               ListCart.delete(index);
               ViewCart();
               setTimeout(() => {
                  actionCart.classList.add('show-triangle');
               }, 0);
            }
         };
      }
   }, 0);
}

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

function totalCarts() {
   const countCart = $('#cartCount');
   const totelCartView = $('#total-view-cart');

   const totalCarts = ListCart.getCarts.reduce((total, curValue) => {
      return Number(total + Number(curValue.product.price.replaceAll(',', '') * curValue.qty));
   }, 0);

   const total = numberMoney(totalCarts.toString());

   totelCartView.innerHTML = `${total[0] === ',' ? total.replace(',', '') : total} ₫`;
   countCart.innerHTML = ListCart.getCarts.reduce((total, curValue) => {
      return Number(total + Number(curValue.qty));
   }, 0);
}

function ViewCart() {
   // Cart action
   const countCart = $('#cartCount');
   const cartViewScroll = $('.cart-view-scroll');

   totalCarts();

   if (ListCart.getCarts.length > 0) {
      cartViewScroll.innerHTML = ListCart.getCarts
         .map((element) => {
            let tempColorIndex = 0;
            element.product.colors.detail.find((element1, index) => {
               tempColorIndex = index;
               return element1.color.toLowerCase() === element.detail.option1.trim().toLowerCase();
            });
            return CartView({
               namePro: element.product.name,
               linkTo: `/product/index.html?id=${element.product._id}`,
               img: element.product.colors.detail[tempColorIndex].imgs.firstImg,
               color: element.detail.option1,
               size: element.detail.option2,
               price: element.product.price,
            });
         })
         .join('');
   } else {
      cartViewScroll.innerHTML = `
                                    <div class="mini-cart__empty">
                                       <td>			
                                          <div class="svgico-mini-cart">
                                             <svg width="81" height="70" viewBox="0 0 81 70"><g transform="translate(0 2)" stroke-width="4" fill="none" fill-rule="evenodd"><circle stroke-linecap="square" cx="34" cy="60" r="6"></circle><circle stroke-linecap="square" cx="67" cy="60" r="6"></circle><path d="M22.9360352 15h54.8070373l-4.3391876 30H30.3387146L19.6676025 0H.99560547"></path></g></svg>
                                          </div>					
                                          Hiện chưa có sản phẩm					
                                       </td>								
                                    </div>
                                 `;
   }

   countCart.innerHTML = ListCart.getCarts.reduce((total, curValue) => {
      return Number(total + Number(curValue.qty));
   }, 0);

   eventCarts();
}

ViewCart();
export default ViewCart;
