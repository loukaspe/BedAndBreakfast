import axios from "axios";
import {
  API_BASE_URL,
  API_LOGIN_ROUTE,
  API_REGISTER_ROUTE,
} from "../../constants/apiConstants";
import React from "react";

class Authenticator {
  login(data) {
    return axios.post(API_BASE_URL + API_LOGIN_ROUTE, data).then((response) => {
      if (response.data.token && response.data.userData) {
        localStorage.setItem("user", JSON.stringify(response.data));
      }
      return response.data;
    });
  }

  logout() {
    localStorage.removeItem("user");
  }

  register(data) {
    return axios
      .post(API_BASE_URL + API_REGISTER_ROUTE, data)
      .then(function (response) {
        console.log(response.data);
        //TODO: SuccessPage
      })
      .catch(function (error) {
        console.log(error);
        //TODO: FailPage
      });
  }

  getCurrentUser() {
    return JSON.parse(localStorage.getItem("user"));
  }

  getCurrentUserToken() {
    const user = this.getCurrentUser();

    if (user && user.token) {
      return { Authorization: "Bearer " + user.token };
    } else {
      return {};
    }
  }

  getCurrentUserRole() {
    const user = this.getCurrentUser();

    if (user && user.role) {
      return user.userData.role;
    } else {
      return "";
    }
  }

  getCurrentUserId() {
    const user = this.getCurrentUser();

    if (user && user.userData && user.userData.id) {
      return user.userData.id;
    } else {
      return "";
    }
  }
}

export default new Authenticator();
