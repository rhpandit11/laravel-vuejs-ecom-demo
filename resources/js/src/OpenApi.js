import axios from "axios";
const base_url = window.location.origin;
let BaseApi = axios.create({
    baseURL : base_url+"/api/"
});

let Api = function() {
    
    return BaseApi;
};

export default Api;