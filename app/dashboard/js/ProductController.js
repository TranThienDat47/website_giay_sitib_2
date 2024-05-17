class ProductController {


   constructor() {
   }

   async getProducts() {
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
         action: 'all_product'
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
            var list_product_id = [];
            const newData = data[0];
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

                  var stocks = 0;

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
                              qty: size[14],
                              productDetail_id: size[17]
                           };
                        });

                        const listOther = [itemDetail[8] || '', itemDetail[9] || '', itemDetail[10] || '', itemDetail[11] || '']
                        stocks += total_qty;
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

                  detail_cur = detail_cur.filter(item => {
                     return (item !== undefined);
                  });

                  return {
                     status: item[18],
                     _id: item[0],
                     name: item[1],
                     description: item[2],
                     price: price,
                     qty: stocks,
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
         })
         .catch(error => {
            console.error(error);
         });

      const dataProduct = await response;
      this.Products = dataProduct;


      return dataProduct;
   }

   add(product) {
      const flagAdd = this.Products.find((element) => {
         return parseInt(element._id) === parseInt(product._id);
      });

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

      function addProduct(product) {

         const name = product.name, description = product.description, price = product.price;
         var category_id = product.shoeTypes.gender;

         const url = '../api/ProductAPI.php';
         const data = {
            action: 'add_product',
            name,
            description,
            price,
            category_id
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
            .then((data) => {

               product.colors.detail.map(async (element) => {
                  await element.detail.map(async (element1) => {
                     const productdetail = {
                        img1: element.imgs.firstImg, img2: element.imgs.secondeImg,
                        img3: element.imgs.orthers[0] || null, img4: element.imgs.orthers[1] || null, img5: element.imgs.orthers[2] || null,
                        img6: element.imgs.orthers[3] || null, color: element.color, size: element1.size
                     };
                     await addProductDetail(data, productdetail);
                  })
               })

               return true;
            }).then((data) => {
               if (data) {
                  window.location.href = "./DB_Product.php"
               }

            })
            .catch(error => {
               console.error(error);
            });
      }

      async function updateProductDetail(product_id, productDetail) {
         const img1 = productDetail.img1, img2 = productDetail.img2, img3 = productDetail.img3, img4 = productDetail.img4, img5 = productDetail.img5, img6 = productDetail.img6, color = productDetail.color, size = productDetail.size;

         const url = '../api/ProductAPI.php';
         const data = {
            action: 'update_product_detail',
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

      function updateProduct(product) {

         const product_id = product._id, name = product.name, description = product.description, price = product.price;
         var category_id = product.shoeTypes.gender;

         const url = '../api/ProductAPI.php';
         const data = {
            action: 'update_product',
            product_id,
            name,
            description,
            price,
            category_id
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
            .then((data) => {

               product.colors.detail.map(async (element) => {
                  await element.detail.map(async (element1) => {
                     const productdetail = {
                        img1: element.imgs.firstImg, img2: element.imgs.secondeImg,
                        img3: element.imgs.orthers[0] || null, img4: element.imgs.orthers[1] || null, img5: element.imgs.orthers[2] || null,
                        img6: element.imgs.orthers[3] || null, color: element.color, size: element1.size
                     };
                     await updateProductDetail(product_id, productdetail);
                  })
               })

               return true;
            }).then((data) => {
               if (data) {
                  // window.location.href = "./DB_Product.php"
               }

            })
            .catch(error => {
               console.error(error);
            });
      }

      if (!flagAdd) {
         addProduct(product);
      } else {
         // updateProduct(product);
      }
   }

   // delete(productID) {
   //    this.Products = this.Products.filter((item) => Number(item._id) !== Number(productID));
   //    localStorage.setItem('Products', JSON.stringify(this.Products));
   // }

   // find(productID) {
   //    return this.Products.filter((item) => Number(item._id) === Number(productID));
   // }

   // findAll(value) {
   //    return this.Products.filter(
   //       (item) =>
   //          item._id.toString().toLowerCase().search(value.toString().toLowerCase()) >= 0 ||
   //          item.name.toString().toLowerCase().search(value.toString().toLowerCase()) >= 0,
   //    );
   // }
}

export default new ProductController();
