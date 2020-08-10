/* global localStorage */

import axios from 'axios'
import Admin from '@/Models/Admin'

const Token = Admin.query().first();

const API_URL = process.env.API_URL || 'http://missmed.co.th/s1/api/v1'

if(Token){
  const Tokens = Token.data.api_token
}else{
  const Tokens = ""
}
export default axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json', 
    'Authorization': Tokens
  }
})


