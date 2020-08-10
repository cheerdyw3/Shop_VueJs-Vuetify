
import axios from 'axios';
import Admin from '@/Models/Admin'

const Token = Admin.query().first(); 
 
export const HTTP = axios.create({
    // baseURL: process.env.VUE_APP_API+'api/v1',  
    baseURL: 'http://localhost/adminAppLK/public/api/v1', 
    headers: {
        "Content-Type": "text/json",
        "Authorization": Token.data.token_type +' '+ Token.data.token
    }
});


 