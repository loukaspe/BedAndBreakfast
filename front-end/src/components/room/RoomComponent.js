import React, { Component } from "react";
import PropTypes from "prop-types";
import RandomRoomImage from "./RandomRoomImage";
import Authenticator from "../../services/user/authenticator";
import RoomService from "../../services/room/roomService";
import { withRouter } from "react-router-dom";

class RoomComponent extends Component {
  constructor(props, context) {
    super(props, context);

    let totalDays =
      this.props.endDate.getDate() - this.props.startDate.getDate();

    let totalPrice = this.props.pricePerNight * totalDays;
    this.state = { totalDays: totalDays, totalPrice: totalPrice };

    this.loadScript = this.loadScript.bind(this);
    this.handleScriptLoad = this.handleScriptLoad.bind(this);
  }

  componentDidMount() {
    this.loadScript(
      `https://maps.googleapis.com/maps/api/js?key=${process.env.REACT_APP_GOOGLE_API_KEY}&libraries=places`,
      this.handleScriptLoad
    );
  }

  loadScript = (url, callback) => {
    let script = document.createElement("script");
    script.type = "text/javascript";

    if (script.readyState) {
      script.onreadystatechange = function () {
        if (
          script.readyState === "loaded" ||
          script.readyState === "complete"
        ) {
          script.onreadystatechange = null;
          callback();
        }
      };
    } else {
      script.onload = () => callback();
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
  };

  handleScriptLoad = () => {
    let skata = document.getElementById("map");
    console.log(skata);
    const uluru = { lat: -25.363, lng: 131.044 };
    const map = new window.google.maps.Map(document.getElementById("map"), {
      center: uluru,
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
          pathname: "/successReservation",
        });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  render() {
    return (
      <div className={"bg-light pl-3 pr-3 pt-1 pb-1 mt-3 mb-3"}>
        <div className={"h2 font-weight-bold row p-1"}>
          {this.props.roomType} in {this.props.area}
        </div>
        <div className="row p-1">
          <div className="col-md-7">
            <RandomRoomImage />
          </div>
          <div className="col-md-5">
            <div className="row p-1">{this.props.pricePerNight}€ /night</div>
            <div className="row p-1">
              <button
                type="button"
                className="btn btn-primary"
                onClick={this.handleClickReserve}
              >
                Reserve
              </button>
            </div>
            <div className="row p-1">
              From {this.props.startDate.toISOString().substr(0, 10)}
            </div>
            <div className="row p-1">
              To {this.props.endDate.toISOString().substr(0, 10)}
            </div>
            <div className="row p-1">Total: {this.state.totalPrice}€</div>
          </div>
        </div>
        <div className="row p-1">{this.props.description}</div>
        <div className="row p-1">
          <div className="col-md-7">
            <div className="h4 font-weight-bold row p-1">Room Arrangements</div>
            <div className="h5 row p-1">
              <div className="col">
                {this.props.hasKitchen ? (
                  <div className="row p-1">Kitchen</div>
                ) : (
                  ""
                )}
                {this.props.hasLivingRoom ? (
                  <div className="row p-1">Living Room</div>
                ) : (
                  ""
                )}
                <div className="row p-1">
                  {this.props.totalBathrooms} Bathrooms
                </div>
                <div className="row p-1">
                  {this.props.totalBedrooms} Bedrooms
                </div>
                <div className="row p-1">{this.props.totalBeds} Beds</div>
              </div>
            </div>
            <div className="h4 font-weight-bold row p-1">Amenities</div>
            <div className="h5 row p-1">
              <div className="col">
                {this.props.hasTV ? <div className="row p-1">TV</div> : ""}
                {this.props.hasAirConditioning ? (
                  <div className="row p-1">Air Conditioning</div>
                ) : (
                  ""
                )}
                {this.props.hasHeating ? (
                  <div className="row p-1">Heating</div>
                ) : (
                  ""
                )}
                {this.props.hasWifi ? <div className="row p-1">WiFi</div> : ""}
                {this.props.hasParking ? (
                  <div className="row p-1">Parking</div>
                ) : (
                  ""
                )}
                {this.props.hasElevator ? (
                  <div className="row p-1">Elevator</div>
                ) : (
                  ""
                )}
                {this.props.isSmokingInsideAllowed ? (
                  <div className="row p-1">Smoking Inside Allowed</div>
                ) : (
                  ""
                )}
                {this.props.arePetsAllowed ? (
                  <div className="row p-1">Pets Allowed</div>
                ) : (
                  ""
                )}
                {this.props.arePartiesAllowed ? (
                  <div className="row p-1">Parties Allowed</div>
                ) : (
                  ""
                )}{" "}
              </div>
            </div>
          </div>
          <div className="col-md-5">
            <div id="map"></div>
          </div>
        </div>
      </div>
    );
  }
}

RoomComponent.propTypes = {
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

export default withRouter(RoomComponent);
