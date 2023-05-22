import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "/api/",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
    "Access-Control-Allow-Origin": "*",
    "X-Requested-With": "XMLHttpRequest",
  },
});

export default axiosInstance;
