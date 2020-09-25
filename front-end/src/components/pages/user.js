import React from "react";
import Layout from "../global/Layout";
import Background from "../../assets/images/newYork.jpg";
import UserComponent from "../user/UserComponent";

const User = (props) => {
  return (
    <>
      <Layout
        children={
          <div
            className={"row justify-content-center"}
            style={{ backgroundImage: `url(${Background})` }}
          >
            <UserComponent />
          </div>
        }
      ></Layout>
    </>
  );
};

export default User;
