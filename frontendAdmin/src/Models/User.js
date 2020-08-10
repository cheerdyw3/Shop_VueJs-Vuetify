import { Model } from '@vuex-orm/core'   

export default class Admin extends Model { 

  static get entity () {
    return 'admin'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {   
        api_token: this.attr(null),
        email: this.attr(null),
        name: this.attr(null),
        username: this.attr(null), 
    }
  } 
}
 