import { Model } from '@vuex-orm/core'   

export default class Member extends Model { 

  static get entity () {
    return 'Member'
  }

  // `this.belongsTo` is for the belongs to relationship.
  static fields () {
    return {  
        id : this.attr(null),
        region_id : this.attr(''),
        name : this.attr(''),
        shop : this.attr(''),
        phone : this.attr(''),
        email : this.attr(''),
        password : this.attr(''),
        address : this.attr(''),
        district : this.attr(''),
        amphoe : this.attr(''),
        province : this.attr(''),
        zipcode : this.attr(''),
        image : this.attr(''),
        created_at : this.attr(''),
        updated_at : this.attr(''),
    }
  } 
}


