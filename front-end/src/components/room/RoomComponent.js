import React, { Component } from "react";
import PropTypes from "prop-types";
import RandomRoomImage from "./RandomRoomImage";

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
    console.log("MPHKEFAAFEAFW");
    let skata = document.getElementById("map");
    console.log(skata);
    const uluru = { lat: -25.363, lng: 131.044 };
    const map = new window.google.maps.Map(document.getElementById("map"), {
      center: uluru,
    });
  };

  render() {
    return (
      <div>
        <div className={"h2 font-weight-bold row"}>
          {this.props.roomType} in {this.props.area}
        </div>
        <div className="row">
          <div className="col-md-7">
            <RandomRoomImage />
          </div>
          <div className="col-md-5">
            <div className="row">{this.props.pricePerNight}€ /night</div>
            <div className="row">
              <button
                type="button"
                className="btn btn-primary"
                onClick={this.handleClickReserve}
              >
                Reserve
              </button>
            </div>
            <div className="row">
              From {this.props.startDate.toISOString().substr(0, 10)}
            </div>
            <div className="row">
              To {this.props.endDate.toISOString().substr(0, 10)}
            </div>
            <div className="row">Total: {this.state.totalPrice}€</div>
          </div>
        </div>
        <div className="row">{this.props.description}</div>
        <div className="row">
          <div className="col-md-7">
            <div className="h4 font-weight-bold row">Room Arrangements</div>
            <div className="h5 row">
              <div className="col">
                {this.props.hasKitchen ? (
                  <div className="row">Kitchen</div>
                ) : (
                  ""
                )}
                {this.props.hasLivingRoom ? (
                  <div className="row">Living Room</div>
                ) : (
                  ""
                )}
                <div className="row">{this.props.totalBathrooms} Bathrooms</div>
                <div className="row">{this.props.totalBedrooms} Bedrooms</div>
                <div className="row">{this.props.totalBeds} Beds</div>
              </div>
            </div>
            <div className="h4 font-weight-bold row">Amenities</div>
            <div className="h5 row">
              <div className="col">
                {this.props.hasTV ? '<div className="row">TV</div>' : ""}
                {this.props.hasAirConditioning ? (
                  <div className="row">Air Conditioning</div>
                ) : (
                  ""
                )}
                {this.props.hasHeating ? (
                  <div className="row">Heating</div>
                ) : (
                  ""
                )}
                {this.props.hasWifi ? <div className="row">WiFi</div> : ""}
                {this.props.hasParking ? (
                  <div className="row">Parking</div>
                ) : (
                  ""
                )}
                {this.props.hasElevator ? (
                  <div className="row">Elevator</div>
                ) : (
                  ""
                )}
                {this.props.isSmokingInsideAllowed ? (
                  <div className="row">Smoking Inside Allowed</div>
                ) : (
                  ""
                )}
                {this.props.arePetsAllowed ? (
                  <div className="row">Pets Allowed</div>
                ) : (
                  ""
                )}
                {this.props.arePartiesAllowed ? (
                  <div className="row">Parties Allowed</div>
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

export default RoomComponent;
