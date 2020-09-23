import React, { Component } from "react";
import Layout from "../global/Layout";
import RegisterForm from "../forms/registerForm";
import Background from "../../assets/images/newYork.jpg";

class Register extends Component {
  render() {
    return (
      <>
        <Layout
          children={
            <div
              className={"row justify-content-center"}
              style={{ backgroundImage: `url(${Background})` }}
            >
              <RegisterForm />
            </div>
          }
        ></Layout>
      </>
    );
  }
}

export default Register;
