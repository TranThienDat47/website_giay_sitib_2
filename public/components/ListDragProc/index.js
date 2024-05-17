const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const checkNode = (parent, children) => {
   let node = children.parentNode;
   while (node !== null) {
      if (node === parent) return true;
      node = node.parentNode;
   }
   return false;
};

function ListDragProc(id = 'ListDragProc_0', data = []) {
   setTimeout(() => {
      const itemSlideDrag = $$(`#ListDragProc_${id} .slide-drag-item`);
      const listDrag = $(`#ListDragProc_${id} .slide-drag-stage`);
      const btnDragLeft = $(`#ListDragProc_${id} .listDrag__left`);
      const btnDragRight = $(`#ListDragProc_${id} .listDrag__right`);

      if (data.length <= 5) {
         btnDragLeft.style.display = 'none';
         btnDragRight.style.display = 'none';
      }

      let flagDrag = false,
         curTranslateX,
         tempDrag = 0,
         tempTranslateX = 0,
         tempElement,
         tempRightLastItem,
         tempTranslateXLast,
         tempMouseMoveList = false;

      const elemEventHandler = function (e) {
         e.preventDefault();
         e.stopPropagation();
      };
      //ok
      btnDragRight.onclick = function (e) {
         if (listDrag.children.length > 5) {
            listDrag.style.transition = 'all 0.6s ease 0s';

            const w = listDrag.getBoundingClientRect().width;
            const itemProc = (20 * w) / 100;
            tempTranslateX = +listDrag.style.transform
               .replace('translateX', '')
               .replace('(', '')
               .replace(')', '')
               .replace('px', '');
            const curTranslateX = tempTranslateX - itemProc;
            if (-curTranslateX > itemProc * (itemSlideDrag.length - 5)) {
               listDrag.style.transform = `translateX(${-itemProc * (itemSlideDrag.length - 5)}px)`;
            } else listDrag.style.transform = `translateX(${curTranslateX}px)`;
         }
      };

      btnDragLeft.onclick = function (e) {
         if (listDrag.children.length > 5) {
            listDrag.style.transition = 'all 0.6s ease 0s';

            const w = listDrag.getBoundingClientRect().width;
            const itemProc = (20 * w) / 100;
            tempTranslateX = +listDrag.style.transform
               .replace('translateX', '')
               .replace('(', '')
               .replace(')', '')
               .replace('px', '');
            const curTranslateX = tempTranslateX + itemProc;
            tempRightLastItem =
               itemSlideDrag[itemSlideDrag.length - 1].getBoundingClientRect().right;

            if (curTranslateX > 0) listDrag.style.transform = `translateX(0px)`;
            else listDrag.style.transform = `translateX(${curTranslateX}px)`;
         }
      };

      function handleDragListProc(e) {
         const x = e.clientX - tempDrag;
         const w = listDrag.getBoundingClientRect().width;
         const itemProc = (20 * w) / 100;

         curTranslateX = tempTranslateX + x;
         listDrag.style.transform = `translateX(${curTranslateX}px)`;

         tempRightLastItem = itemSlideDrag[itemSlideDrag.length - 1].getBoundingClientRect().right;

         const rightList = $(`#ListDragProc_${id}`).getBoundingClientRect().right;

         tempTranslateXLast = itemProc * (itemSlideDrag.length - 5);

         if (curTranslateX > 0) {
            listDrag.style.transform = `translateX(${curTranslateX / 5}px)`;
         } else if (tempRightLastItem < rightList) {
            listDrag.style.transform = `translateX(${
               -tempTranslateXLast + (curTranslateX + tempTranslateXLast) / 5
            }px)`;
         }
      }

      listDrag.onmousedown = function (e) {
         if (listDrag.children.length > 5) {
            listDrag.style.transition = 'none';
            tempDrag = e.clientX;
            tempTranslateX = +listDrag.style.transform
               .replace('translateX', '')
               .replace('(', '')
               .replace(')', '')
               .replace('px', '');
            flagDrag = true;
            tempMouseMoveList = false;
         }
      };

      document.onmousemove = function (e) {
         if (flagDrag) {
            handleDragListProc(e);
            if (checkNode(listDrag, e.target)) {
               tempElement = e.target;
            } else tempElement = null;
            tempMouseMoveList = true;
         }
      };

      document.onmouseup = function () {
         if (flagDrag) {
            if (tempElement) {
               if (tempMouseMoveList)
                  tempElement.addEventListener('click', elemEventHandler, false);
               else tempElement.removeEventListener('click', elemEventHandler, false);
            }
            listDrag.style.transition = 'all 0.6s ease 0s';

            const w = listDrag.getBoundingClientRect().width;
            const itemProc = (20 * w) / 100;

            const tempTranslateX = +listDrag.style.transform
               .replace('translateX', '')
               .replace('(', '')
               .replace(')', '')
               .replace('px', '');

            if (curTranslateX > 0) listDrag.style.transform = `translateX(0px)`;
            else if (-itemProc * (itemSlideDrag.length - 5) >= curTranslateX) {
               listDrag.style.transform = `translateX(${-itemProc * (itemSlideDrag.length - 5)}px)`;
            } else if (w % curTranslateX > 1)
               if (curTranslateX % itemProc >= itemProc / 2)
                  listDrag.style.transform = `translateX(${
                     20 * Math.round(tempTranslateX / itemProc)
                  }%)`;
               else
                  listDrag.style.transform = `translateX(${
                     itemProc * Math.round(tempTranslateX / itemProc)
                  }px)`;

            flagDrag = false;
         }
      };
   });

   return `
        <div id='ListDragProc_${id}' class="slide-stage-outer">
            <div class="slide-drag-stage">
                ${data
                   .map(
                      (element) => `<div class="slide-drag-item">
                                        ${element}
                                    </div>
                                    `,
                   )
                   .join('')}
            </div>
            <div class ="listDrag__controls">
                <button class ="listDrag__left"><i class="fa-solid fa-chevron-left"></i></button>
                <button class ="listDrag__right"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
    `;
}
export default ListDragProc;
