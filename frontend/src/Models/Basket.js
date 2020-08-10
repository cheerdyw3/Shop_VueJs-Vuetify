import { Model } from '@vuex-orm/core'   
// import Shops from '../Models/Shops'

export default class Basket extends Model { 

  static get entity () {
    return 'Basket'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {
      id: this.attr(null),
        amount: this.attr(''),
        discount: this.attr(''),
        totalPrice: this.attr(''),
        created_at: this.attr(''),
        deliveryId: this.attr(null),
        deliveryCode: this.attr(''),
        deliveryName: this.attr(''),
        deliveryPrice: this.attr(''),
        delivery: this.attr(''),
        description: this.attr(''),
        image: this.attr(''),
        name: this.attr(''),
        price: this.attr(''),
        souvenir_group_id: this.attr(''),
        unit_id: this.attr(''),
        orderStatus: this.attr(''),
        weight: this.attr(''),
        member_id: this.attr(null),
        // Shops: this.belongsTo(Shops, 'member_id'),
    }
  } 
}


