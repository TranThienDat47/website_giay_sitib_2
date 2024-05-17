const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);




function handleAdd() {
   setTimeout(() => {
      const btnAddList = $('.item-category__add');
      const listDel = $$('.btn__del');

      btnAddList.onclick = function () {
         const value = prompt('Vui lòng nhập tên danh mục cần thêm:');
         if (value != null && value.trim() !== '') {
            window.location.href = `./DB_Catelory.php?action=add_category_no_parent&title=${value.trim()}`;
         }
      };

      const listAdd = $$('.btn__add');

      for (let btn of listAdd) {
         btn.onclick = function () {
            const value = prompt('Vui lòng nhập tên danh mục cần thêm:');
            if (value != null && value.trim() !== '') {
               if (btn.parentNode.className === 'item-category__second') {
                  window.location.href = `./DB_Catelory.php?action=add_category&parent_id=${btn.getAttribute("data-id")}&title=${value.trim()}`;
               }
            }
         };
      }


      const listDelLi = $$('.btn__del-li');

      for (let btn of listDelLi) {
         btn.onclick = function () {
            const value = prompt('Nhập "Ok" để đồng ý xoá:');
            if (value === 'Ok' && value.trim() !== '') {
               window.location.href = `./DB_Catelory.php?action=delete_category_no_parent&category_id=${btn.getAttribute("data-id")}`;
            }

         };
      }

      for (let btn of listDel) {
         btn.onclick = function () {
            const value = prompt('Nhập "Ok" để đồng ý xoá:');
            if (value === 'Ok' && value.trim() !== '') {
               if (
                  btn.parentNode.parentNode.parentNode.className === 'item-category__second'
               ) {
                  console.log(btn.getAttribute("data-id"));
                  window.location.href = `./DB_Catelory.php?action=delete_category_no_parent&category_id=${btn.getAttribute("data-id")}`;
               }
            }
         };
      }
   });
}

handleAdd();
