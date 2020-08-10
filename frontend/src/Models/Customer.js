import { Model } from '@vuex-orm/core'   

export default class Customer extends Model { 

  static get entity () {
    return 'customer'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {  
        created_at: this.attr(null),
        id: this.attr(null),
        name: this.attr(null),
        surname: this.attr(null),
        phone: this.attr(null),
        email: this.attr(null),
        password: this.attr(null),
        address: this.attr(null),
        district: this.attr(null),
        amphoe: this.attr(null),
        province: this.attr(null),
        zipcode: this.attr(null),
        image: this.attr(null)
    }
  } 
}


