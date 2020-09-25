import React, { Component } from "react";
import PropTypes from "prop-types";
import RoomListItemComponent from "./RoomListItemComponent";

class RoomListComponent extends Component {
  render() {
    return (
      <div className={"bg-light pl-3 pr-3 pt-1 pb-1 mt-3 mb-3"}>
        {this.props.rooms.map((room) => {
          return (
            <RoomListItemComponent
              id={room.id}
              pricePerNight={room.pricePerNight}
              squareMeters={room.squareMeters}
              totalOccupancy={room.totalOccupancy}
              totalBathrooms={room.totalBathrooms}
              totalBedrooms={room.totalBedrooms}
              totalBeds={room.totalBeds}
              hasTV={room.hasTV}
              hasKitchen={room.hasKitchen}
              hasLivingRoom={room.hasLivingRoom}
              hasAirConditioning={room.hasAirConditioning}
              hasHeating={room.hasHeating}
              hasWifi={room.hasWifi}
              hasParking={room.hasParking}
              hasElevator={room.hasElevator}
              isSmokingInsideAllowed={room.isSmokingInsideAllowed}
              arePetsAllowed={room.arePetsAllowed}
              arePartiesAllowed={room.arePartiesAllowed}
              locality={room.locality}
              address={room.address}
              area={room.area}
              floor={room.floor}
              description={room.description}
              roomType={room.roomType}
              startDate={this.props.startDate}
              endDate={this.props.endDate}
            />
          );
        })}
      </div>
    );
  }
}

RoomListComponent.propTypes = {
  rooms: PropTypes.array,
  startDate: PropTypes.instanceOf(Date),
  endDate: PropTypes.instanceOf(Date),
};

export default RoomListComponent;
