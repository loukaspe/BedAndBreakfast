import React, { Component } from "react";
import Layout from "../global/Layout";
import HostRoomForm from "../forms/hostRoomForm";
import Background from "../../assets/images/newYork.jpg";

class HostRoom extends Component {
  render() {
    return (
      <>
        <Layout
          children={
            <div
              className={"row justify-content-center"}
              style={{ backgroundImage: `url(${Background})` }}
            >
              <HostRoomForm />
            </div>
          }
        ></Layout>
      </>
    );
  }
}

export default HostRoom;
