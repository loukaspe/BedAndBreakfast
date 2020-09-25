import React, { Component } from "react";
import PropTypes from "prop-types";
import RandomRoomImage from "./RandomRoomImage";
import { withRouter } from "react-router-dom";
import RoomService from "../../services/room/roomService";
import Authenticator from "../../services/user/authenticator";

class RoomListItemComponent extends Component {
  constructor(props, context) {
    super(props, context);
  }

  handleClickCheck = () => {
    let room = {
      id: this.props.id,
      pricePerNight: this.props.pricePerNight,
      squareMeters: this.props.squareMeters,
      totalOccupancy: this.props.totalOccupancy,
      totalBathrooms: this.props.totalBathrooms,
      totalBedrooms: this.props.totalBedrooms,
      totalBeds: this.props.totalBeds,
      hasTV: this.props.hasTV,
      hasKitchen: this.props.hasKitchen,
      hasLivingRoom: this.props.hasLivingRoom,
      hasAirConditioning: this.props.hasAirConditioning,
      hasHeating: this.props.hasHeating,
      hasWifi: this.props.hasWifi,
      hasParking: this.props.hasParking,
      hasElevator: this.props.hasElevator,
      isSmokingInsideAllowed: this.props.isSmokingInsideAllowed,
      arePetsAllowed: this.props.arePetsAllowed,
      arePartiesAllowed: this.props.arePartiesAllowed,
      locality: this.props.locality,
      address: this.props.address,
      area: this.props.area,
      floor: this.props.floor,
      description: this.props.description,
      roomType: this.props.roomType,
    };

    this.props.history.push({
      pathname: "/room",
      state: {
        room: room,
        startDate: this.props.startDate,
        endDate: this.props.endDate,
      },
    });
  };

  handleClickReserve = () => {
    let totalDays =
      this.props.endDate.getDate() - this.props.startDate.getDate();

    let totalPrice = this.props.pricePerNight * totalDays;
    this.state = { totalDays: totalDays, totalPrice: totalPrice };

    const data = {
      startDate: this.props.startDate,
      endDate: this.props.endDate,
      price: this.props.pricePerNight,
      total: totalPrice,
      userId: Authenticator.getCurrentUserId(),
      roomId: this.props.id,
    };

    let history = this.props.history;

    RoomService.makeReservation(data)
      .then(function (response) {
        history.push({
          pathname: "/reservationSuccess",
        });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  render() {
    return (
      <div className="row p-4 border-bottom">
        <div className="col-sm">
          <RandomRoomImage />
        </div>
        <div className="col-sm text-justify w-50">
          <div className="row font-weight-bold h4">
            {this.props.roomType} in {this.props.area}
          </div>
          <div className="row h5 text-muted">
            {this.props.totalOccupancy} guests - {this.props.totalBedrooms}{" "}
            bedrooms - {this.props.totalBathrooms} bathrooms -{" "}
            {this.props.totalBeds} beds
            {this.props.hasTV ? " - TV" : ""}
            {this.props.hasKitchen ? " - Kitchen" : ""}
            {this.props.hasLivingRoom ? " - Living Room" : ""}
            {this.props.hasAirConditioning ? " - Air Conditioning" : ""}
            {this.props.hasHeating ? " - Heating" : ""}
            {this.props.hasWifi ? " - Wifi" : ""}
            {this.props.hasParking ? " - Parking" : ""}
            {this.props.hasElevator ? " - Elevator" : ""}
            {this.props.isSmokingInsideAllowed ? " - Smoking Allowed" : ""}
            {this.props.arePartiesAllowed ? " - Parties Allowed" : ""}
            {this.props.arePetsAllowed ? " - Pets Allowed" : ""}
          </div>
          <div className="row font-weight-bold h4">
            <div className="col-sm">
              <button
                type="button"
                className="btn btn-primary"
                onClick={this.handleClickReserve}
              >
                Reservation
              </button>
            </div>
            <div className="col-sm">
              <button
                type="button"
                className="btn btn-info"
                onClick={this.handleClickCheck}
              >
                Check it out
              </button>
            </div>
            <div className="col-sm">{this.props.pricePerNight}€ /night</div>
          </div>
        </div>
      </div>
    );
  }
}

RoomListItemComponent.propTypes = {
  id: PropTypes.number,
  pricePerNight: PropTypes.number,
  squareMeters: PropTypes.number,
  totalOccupancy: PropTypes.number,
  totalBathrooms: PropTypes.number,
  totalBedrooms: PropTypes.number,
  totalBeds: PropTypes.number,
  hasTV: PropTypes.bool,
  hasKitchen: PropTypes.bool,
  hasLivingRoom: PropTypes.bool,
  hasAirConditioning: PropTypes.bool,
  hasHeating: PropTypes.bool,
  hasWifi: PropTypes.bool,
  hasParking: PropTypes.bool,
  hasElevator: PropTypes.bool,
  isSmokingInsideAllowed: PropTypes.bool,
  arePetsAllowed: PropTypes.bool,
  arePartiesAllowed: PropTypes.bool,
  locality: PropTypes.string,
  address: PropTypes.string,
  area: PropTypes.string,
  floor: PropTypes.string,
  description: PropTypes.string,
  roomType: PropTypes.string,
  startDate: PropTypes.instanceOf(Date),
  endDate: PropTypes.instanceOf(Date),
};

export default withRouter(RoomListItemComponent);
