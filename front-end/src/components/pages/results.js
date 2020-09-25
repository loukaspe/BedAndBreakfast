import React from "react";
import Layout from "../global/Layout";
import Background from "../../assets/images/newYork.jpg";
import RoomListComponent from "../room/RoomListComponent";

const Results = (props) => {
  return (
    <>
      <Layout
        children={
          <div
            className={"row justify-content-center"}
            style={{ backgroundImage: `url(${Background})` }}
          >
            <RoomListComponent
              rooms={props.location.state.rooms}
              startDate={props.location.state.startDate}
              endDate={props.location.state.endDate}
            />
          </div>
        }
      ></Layout>
    </>
  );
};

export default Results;
