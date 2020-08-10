import { Model } from '@vuex-orm/core'   
import Basket from '../Models/Basket'

export default class Shops extends Model { 

  static get entity () {
    return 'Shops'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {
        id: this.attr(null),
        name: this.attr(''),
        Basket: this.hasMany(Basket,'member_id'),
        delivery: this.attr(''),
        deliveryFN: this.attr(''),
        deliveryPrice: this.attr(''), 
        deliveryId: this.attr(''),
        deliveryName: this.attr(''),
        discount: this.attr(''),
        price: this.attr(''),
        shipping: this.attr(''),
        total: this.attr(''),
        deliveryAddress: this.attr(''),

        
    }

  } 
}


