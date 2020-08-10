import { Model } from '@vuex-orm/core'   

export default class ProductList extends Model { 

  static get entity () {
    return 'ProductList'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {  
      id: this.attr(null),
      address: this.attr(null),
        amphoe: this.attr(null),
        created_at: this.attr(null),
        district: this.attr(null),
        email: this.attr(null),
        image: this.attr(null),
        name: this.attr(null),
        password: this.attr(null),
        phone: this.attr(null),
        province: this.attr(null),
        region_id: this.attr(null),
        shop: this.attr(null),
        souvenir: this.attr(null),
        zipcode: this.attr(null),
        delivery: this.attr(null)
    }
  } 
}


