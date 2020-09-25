import React, { Component } from "react";
import Authenticator from "../../services/user/authenticator";

import { withRouter } from "react-router-dom";
import RandomProfileImage from "./RandomProfileImage";

class UserComponent extends Component {
  constructor(props, context) {
    super(props, context);
    this.state = Authenticator.getCurrentUser().userData;
  }

  render() {
    return (
      <div className={"container bg-light pl-3 pr-3 pt-1 pb-1 mt-3 mb-3"}>
        <div className={"row  "}>
          <div className={"col"}>{this.state.username}</div>
        </div>
        <div className={"row"}>
          <div className={"col"}>
            <div className={"row"}>First Name: {this.state.firstName}</div>
            <div className={"row"}>Last Name: {this.state.lastName}</div>
            <div className={"row"}>Email: {this.state.email}</div>
            <div className={"row"}>Role: {this.state.role}</div>
            <div className={"row"}>Phone: {this.state.phone}</div>
          </div>
        </div>
      </div>
    );
  }
}

export default withRouter(UserComponent);
