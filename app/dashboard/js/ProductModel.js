class Product {
   constructor(
      _id = Number,
      name = String,
      description = String,
      price = String,
      qty = Number,
      newProc = Boolean,
      shoeTypes = {
         gender: String,
         type: String,
      },
      size = Array,
      colors = {
         list: Array,
         detail: [
            {
               color: String,
               imgs: {
                  firstImg: String,
                  secondeImg: String,
                  orthers: Array,
               },
               qty: Number,
               detail: [
                  {
                     size: Number,
                     qty: Number,
                  },
               ],
            },
         ],
      },
      promotions = Number,
   ) {
      this._id = _id;
      this.name = name;
      this.description = description;
      this.price = price;
      this.qty = qty;
      this.newProc = newProc;
      this.shoeTypes = shoeTypes;
      this.size = size;
      this.colors = colors;
      this.promotions = promotions;
   }

   get getProduct() {
      return {
         _id: this._id,
         name: this.name,
         description: this.description,
         price: this.price,
         qty: this.qty,
         newProc: this.newProc,
         shoeTypes: this.shoeTypes,
         size: this.size,
         colors: this.colors,
         promotions: this.promotions,
      };
   }

   setProduct(
      _id = Number,
      name = String,
      description = String,
      price = String,
      qty = Number,
      newProc = Boolean,
      shoeTypes = {
         gender: String,
         type: String,
      },
      size = Array,
      colors = {
         list: Array,
         detail: [
            {
               color: String,
               imgs: {
                  firstImg: String,
                  secondeImg: String,
                  orthers: Array,
               },
               qty: Number,
               detail: [
                  {
                     size: Number,
                     qty: Number,
                  },
               ],
            },
         ],
      },
      promotions = Number,
   ) {
      this._id = _id;
      this.name = name;
      this.description = description;
      this.price = price;
      this.qty = qty;
      this.newProc = newProc;
      this.shoeTypes = shoeTypes;
      this.size = size;
      this.colors = colors;
      this.promotions = promotions;
   }
}

export default Product;
