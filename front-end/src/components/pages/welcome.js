import React from "react";
import Layout from "../global/Layout";
import MainForm from "../forms/mainForm";
import Background from "../../assets/images/newYork.jpg";

const Welcome = (props) => {
  return (
    <>
      <Layout
        children={
          <div
            className={"row justify-content-center"}
            style={{ backgroundImage: `url(${Background})` }}
          >
            <MainForm />
          </div>
        }
      ></Layout>
    </>
  );
};

export default Welcome;
