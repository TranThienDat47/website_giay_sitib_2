const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

function InfiniteSlide(id = $('.InfiniteSlide__wrapper').length) {
   let timeOut;
   let getWidthSlide;

   timeOut = setTimeout(() => {
      let item = $$(`#InfiniteSlide__${id} .InfiniteSlide__list .InfiniteSlide__item`);
      let btnPrev = $(`#InfiniteSlide__${id} .InfiniteSlide__btn-prev`);
      let btnNext = $(`#InfiniteSlide__${id} .InfiniteSlide__btn-next`);

      getWidthSlide = $(`#InfiniteSlide__${id} .InfiniteSlide__list`).getBoundingClientRect().width;
      for (let i = 0; i < item.length; i++) {
         item[i].style.transform = `translateX(${i * getWidthSlide}px)`;
      }

      document.querySelector(`#InfiniteSlide__${id} .InfiniteSlide__list`).appendChild(item[0]);

      const interval = 4000;
      let slideId;
      let index = 1;

      const startSlide = () => {
         slideId = setInterval(() => {
            getWidthSlide = $(`#InfiniteSlide__${id} .InfiniteSlide__list`).getBoundingClientRect()
               .width;
            moveToNextSlide();
         }, interval);
      };

      const moveToNextSlide = () => {
         let item = $$(`#InfiniteSlide__${id} .InfiniteSlide__list .InfiniteSlide__item`);
         setTimeout(() => {
            for (let i = 0; i < item.length; i++) {
               item[i].style.transform = `translateX(${i * getWidthSlide}px)`;
            }
         });
         $(`#InfiniteSlide__${id} .InfiniteSlide__list`).appendChild(item[0]);
      };

      const moveToPreviousSlide = () => {
         let item = $$(`#InfiniteSlide__${id} .InfiniteSlide__list .InfiniteSlide__item`);
         setTimeout(() => {
            for (let i = 0; i < item.length; i++) {
               item[i].style.transform = `translateX(${i * getWidthSlide}px)`;
            }
         });
         $(`#InfiniteSlide__${id} .InfiniteSlide__list`).prepend(item[item.length - 1]);
      };

      btnNext.addEventListener('click', moveToNextSlide);
      btnPrev.addEventListener('click', moveToPreviousSlide);

      window.addEventListener('resize', (e) => {
         getWidthSlide = $(`#InfiniteSlide__${id} .InfiniteSlide__list`).getBoundingClientRect()
            .width;
      });

      startSlide();

      clearTimeout(timeOut);
   });

   return `
    <div id = 'InfiniteSlide__${id}' class="InfiniteSlide__wrapper">
        <ul class="InfiniteSlide__list">
          <li class="InfiniteSlide__item">
              <div class="InfiniteSlide__inner">
                <strong class='InfiniteSlide__inner-first'>
                  <img src="https://file.hstatic.net/1000230642/file/refund_f62cdfe39d9f4b3a8a873fb4a8065303.png" alt="Hỗ trợ đổi size">
							    Hỗ trợ đổi size
                </strong>
                <span>Tại tất cả cửa hàng trong vòng 1 tuần!</span>
              </div>
          </li>
          <li class="InfiniteSlide__item">
              <div class="InfiniteSlide__inner">
                <strong class='InfiniteSlide__inner-first'>
                  <img src="https://file.hstatic.net/1000230642/file/refund_f62cdfe39d9f4b3a8a873fb4a8065303.png" alt="Miễn phí vận chuyển">
							    Miễn phí vận chuyển
                </strong>
                <span>Với hoá đơn trên 1 triệu ở Hồ Chí Minh</span>
              </div>
          </li>
          <li class="InfiniteSlide__item">
              <div class="InfiniteSlide__inner">
                <strong class='InfiniteSlide__inner-first'>
                  <img src="https://file.hstatic.net/1000230642/file/refund_f62cdfe39d9f4b3a8a873fb4a8065303.png" alt="Miễn phí vận chuyển">
							    Miễn phí vận chuyển
                </strong>
                <span>Với hoá đơn trên 1,5 triệu tại các tỉnh thành khác</span>
              </div>
          </li>
        </ul>

        <div class='InfiniteSlide__controls'>
          <button type="button" class="InfiniteSlide__btn-prev">
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 490.8 490.8" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,490.7999877929687,490.79973220825207)"><path xmlns="http://www.w3.org/2000/svg" style="" d="M135.685,3.128c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82 l227.115,227.136L120.581,472.461c-4.237,4.093-4.354,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262 c0.089-0.086,0.176-0.173,0.262-0.262l234.667-234.667c4.164-4.165,4.164-10.917,0-15.083L135.685,3.128z" fill="#f44336" data-original="#f44336"></path><path xmlns="http://www.w3.org/2000/svg" d="M128.133,490.68c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571l227.136-227.115 L120.581,18.232c-4.171-4.171-4.171-10.933,0-15.104c4.171-4.171,10.933-4.171,15.104,0l234.667,234.667 c4.164,4.165,4.164,10.917,0,15.083L135.685,487.544C133.685,489.551,130.967,490.68,128.133,490.68z" fill="#000000" data-original="#000000" class=""></path><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg>
        </button>

        <button type="button" class="InfiniteSlide__btn-next">
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 490.8 490.8" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" style="" d="M135.685,3.128c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82 l227.115,227.136L120.581,472.461c-4.237,4.093-4.354,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262 c0.089-0.086,0.176-0.173,0.262-0.262l234.667-234.667c4.164-4.165,4.164-10.917,0-15.083L135.685,3.128z" fill="#f44336" data-original="#f44336"></path><path xmlns="http://www.w3.org/2000/svg" d="M128.133,490.68c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571l227.136-227.115 L120.581,18.232c-4.171-4.171-4.171-10.933,0-15.104c4.171-4.171,10.933-4.171,15.104,0l234.667,234.667 c4.164,4.165,4.164,10.917,0,15.083L135.685,487.544C133.685,489.551,130.967,490.68,128.133,490.68z" fill="#000000" data-original="#000000"></path><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg>
          </button>
        </div>
    </div>`;
}
export default InfiniteSlide;
