import { Model } from '@vuex-orm/core'

export default class TypeLogin extends Model { 

  static get entity () {
    return 'TypeLogin'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {
        type: this.attr(''),
    }

  } 
}


