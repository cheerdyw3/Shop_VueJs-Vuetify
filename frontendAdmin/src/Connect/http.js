import axios from 'axios';
export const HTTP = axios.create({
    // baseURL: 'http://10.0.0.46:8081/api/v1', 
    baseURL: 'http://localhost/adminAppLK/public/api/v1', 
    headers: {
        "Content-Type": "text/json",
    }
});
