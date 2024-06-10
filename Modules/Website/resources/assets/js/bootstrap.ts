import axios from "axios";
declare global{
    interface Window {
        axios: any;
    }
}
window.axios = axios;