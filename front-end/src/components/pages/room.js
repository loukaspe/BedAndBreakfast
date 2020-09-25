import React from "react";
import Layout from "../global/Layout";
import Background from "../../assets/images/newYork.jpg";
import RoomComponent from "../room/RoomComponent";

const Room = (props) => {
  return (
    <>
      <Layout
        children={
          <div
            className={"row justify-content-center"}
            style={{ backgroundImage: `url(${Background})` }}
          >
            <RoomComponent
              id={props.location.state.room.id}
              pricePerNight={props.location.state.room.pricePerNight}
              squareMeters={props.location.state.room.squareMeters}
              totalOccupancy={props.location.state.room.totalOccupancy}
              totalBathrooms={props.location.state.room.totalBathrooms}
              totalBedrooms={props.location.state.room.totalBedrooms}
              totalBeds={props.location.state.room.totalBeds}
              hasTV={props.location.state.room.hasTV}
              hasKitchen={props.location.state.room.hasKitchen}
              hasLivingRoom={props.location.state.room.hasLivingRoom}
              hasAirConditioning={props.location.state.room.hasAirConditioning}
              hasHeating={props.location.state.room.hasHeating}
              hasWifi={props.location.state.room.hasWifi}
              hasParking={props.location.state.room.hasParking}
              hasElevator={props.location.state.room.hasElevator}
              isSmokingInsideAllowed={
                props.location.state.room.isSmokingInsideAllowed
              }
              arePetsAllowed={props.location.state.room.arePetsAllowed}
              arePartiesAllowed={props.location.state.room.arePartiesAllowed}
              locality={props.location.state.room.locality}
              address={props.location.state.room.address}
              area={props.location.state.room.area}
              floor={props.location.state.room.floor}
              description={props.location.state.room.description}
              roomType={props.location.state.room.roomType}
              startDate={props.location.state.startDate}
              endDate={props.location.state.endDate}
            />
          </div>
        }
      ></Layout>
    </>
  );
};

export default Room;
