import React, { Component } from "react";
import RoomService from "../../services/room/roomService";
import {
  APPARTMENT_ROOM_TYPE,
  CHALET_ROOM_TYPE,
  HOTEL_ROOM_TYPE,
  GUEST_ROOM_ROOM_TYPE,
  HOUSE_ROOM_TYPE,
  MAISONETTE_ROOM_TYPE,
} from "../../constants/enumsConstants";
import { formValidator } from "../../services/validation/formValidator";
import SearchLocationAddressInput from "../inputs/SearchLocationAddressInput";

class HostRoomForm extends Component {
  constructor(props) {
    super(props);

    this.state = {
      pricePerNight: 0,
      locality: "",
      area: "",
      squareMeters: 0,
      floor: "",
      description: "",
      roomType: APPARTMENT_ROOM_TYPE,
      totalOccupancy: 0,
      totalBathrooms: 0,
      totalBedrooms: 0,
      totalBeds: 0,
      hasTV: false,
      hasKitchen: false,
      hasLivingRoom: false,
      hasAirConditioning: false,
      hasHeating: false,
      hasWifi: false,
      hasParking: false,
      hasElevator: false,
      isSmokingInsideAllowed: false,
      arePetsAllowed: false,
      arePartiesAllowed: false,

      pricePerNightError: "",
      addressError: "",
      squareMetersError: "",
      floorError: "",
      descriptionError: "",
      roomTypeError: "",
      totalOccupancyError: "",
      totalBathroomsError: "",
      totalBedroomsError: "",
      totalBedsError: "",
      hasTVError: "",
      hasKitchenError: "",
      hasLivingRoomError: "",
      hasAirConditioningError: "",
      hasHeatingError: "",
      hasWifiError: "",
      hasParkingError: "",
      hasElevatorError: "",
      isSmokingInsideAllowedError: "",
      arePetsAllowedError: "",
      arePartiesAllowedError: "",
    };

    this.handleSubmit = this.handleSubmit.bind(this);
    this.callApi = this.callApi.bind(this);
    this.validateFields = this.validateFields.bind(this);
    this.setAreaAndLocalityFromGoogleAutocomplete = this.setAreaAndLocalityFromGoogleAutocomplete.bind(
      this
    );
  }

  callApi = () => {
    const data = {
      pricePerNight: this.state.pricePerNight,
      locality: this.state.locality,
      area: this.state.area,
      squareMeters: this.state.squareMeters,
      floor: this.state.floor,
      description: this.state.description,
      roomType: this.state.roomType,
      totalOccupancy: this.state.totalOccupancy,
      totalBathrooms: this.state.totalBathrooms,
      totalBedrooms: this.state.totalBedrooms,
      totalBeds: this.state.totalBeds,
      hasTV: this.state.hasTV,
      hasKitchen: this.state.hasKitchen,
      hasLivingRoom: this.state.hasLivingRoom,
      hasAirConditioning: this.state.hasAirConditioning,
      hasHeating: this.state.hasHeating,
      hasWifi: this.state.hasWifi,
      hasParking: this.state.hasParking,
      hasElevator: this.state.hasElevator,
      isSmokingInsideAllowed: this.state.isSmokingInsideAllowed,
      arePetsAllowed: this.state.arePetsAllowed,
      arePartiesAllowed: this.state.arePartiesAllowed,
    };

    RoomService.registerRoom(data)
      .then(function (response) {
        console.log(response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  validateFields = () => {
    let isFormValid = true;

    this.setState({
      pricePerNightError: "",
      addressError: "",
      squareMetersError: "",
      floorError: "",
      descriptionError: "",
      roomTypeError: "",
      totalOccupancyError: "",
      totalBathroomsError: "",
      totalBedroomsError: "",
      totalBedsError: "",
      hasTVError: "",
      hasKitchenError: "",
      hasLivingRoomError: "",
      hasAirConditioningError: "",
      hasHeatingError: "",
      hasWifiError: "",
      hasParkingError: "",
      hasElevatorError: "",
      isSmokingInsideAllowedError: "",
      arePetsAllowedError: "",
      arePartiesAllowedError: "",
    });

    let hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.pricePerNight
    );
    if (hasValidationReturnedError) {
      this.setState({ pricePerNightError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.locality
    );
    if (hasValidationReturnedError) {
      this.setState({ addressError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.area
    );
    if (hasValidationReturnedError) {
      this.setState({ addressError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.squareMeters
    );
    if (hasValidationReturnedError) {
      this.setState({ squareMetersError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.floor
    );
    if (hasValidationReturnedError) {
      this.setState({ floorError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.description
    );
    if (hasValidationReturnedError) {
      this.setState({ descriptionError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateRoomType(
      this.state.roomType
    );
    if (hasValidationReturnedError) {
      this.setState({ roomTypeError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.totalOccupancy
    );
    if (hasValidationReturnedError) {
      this.setState({ totalOccupancyError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.totalBathrooms
    );
    if (hasValidationReturnedError) {
      this.setState({ totalBathroomsError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.totalBedrooms
    );
    if (hasValidationReturnedError) {
      this.setState({ totalBedroomsError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNumberNotZero(
      this.state.totalBeds
    );
    if (hasValidationReturnedError) {
      this.setState({ totalBedsError: hasValidationReturnedError });
      isFormValid = false;
    }

    return isFormValid;
  };

  setAreaAndLocalityFromGoogleAutocomplete = (area, locality) => {
    this.setState({
      area: area,
      locality: locality,
    });
  };

  handleSubmit = async (event) => {
    event.preventDefault();
    if (this.validateFields()) {
      this.callApi();
    }
  };

  render() {
    return (
      <form
        onSubmit={this.handleSubmit}
        className={"bg-light pl-3 pr-3 pt-1 pb-1 mt-3 mb-3"}
      >
        <div className="form-group">
          <label htmlFor="pricePerNight">Price Per Night (in €):</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ pricePerNight: event.target.value })
            }
            className="form-control"
            id="pricePerNight"
            aria-describedby="pricePerNightHelp"
            value={this.state.pricePerNight}
          />
          <small id="pricePerNightHelp" className="form-text text-muted">
            Please set the price of the room for each night:
          </small>
          <span style={{ color: "red" }}>{this.state.pricePerNightError}</span>
        </div>

        <div className="form-group">
          <label>Address:</label>
          <SearchLocationAddressInput
            onChange={this.setAreaAndLocalityFromGoogleAutocomplete}
          />
          <small className="form-text text-muted">
            Please set the address of the room:
          </small>
          <span style={{ color: "red" }}>{this.state.addressError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="squareMeters">Square Meters:</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ squareMeters: event.target.value })
            }
            className="form-control"
            id="squareMeters"
            aria-describedby="squareMetersHelp"
            value={this.state.squareMeters}
          />
          <small id="squareMetersHelp" className="form-text text-muted">
            Please set the square meters of the room:
          </small>
          <span style={{ color: "red" }}>{this.state.squareMetersError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="floor">Floor:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ floor: event.target.value })}
            className="form-control"
            id="floor"
            aria-describedby="floorHelp"
            value={this.state.floor}
          />
          <small id="floorHelp" className="form-text text-muted">
            Please type the floor your room is on:
          </small>
          <span style={{ color: "red" }}>{this.state.floorError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="description">Description:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ description: event.target.value })
            }
            className="form-control"
            id="description"
            aria-describedby="descriptionHelp"
            value={this.state.description}
          />
          <small id="descriptionHelp" className="form-text text-muted">
            Tell us a few words about the room:
          </small>
          <span style={{ color: "red" }}>{this.state.descriptionError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="roomType">Room Type:</label>

          <select
            className="form-control"
            id="roomType"
            aria-describedby="roomTypeHelp"
            value={this.state.roomType}
            onChange={(event) =>
              this.setState({ roomType: event.target.value })
            }
          >
            <option value={APPARTMENT_ROOM_TYPE}>Appartment</option>
            <option value={CHALET_ROOM_TYPE}>Chalet</option>
            <option value={HOTEL_ROOM_TYPE}>Hotel</option>
            <option value={GUEST_ROOM_ROOM_TYPE}>Guest Room</option>
            <option value={HOUSE_ROOM_TYPE}>House</option>
            <option value={MAISONETTE_ROOM_TYPE}>Maisonette</option>
          </select>
          <small id="roomTypeHelp" className="form-text text-muted">
            Please select the type that best describes your room
          </small>
          <span style={{ color: "red" }}>{this.state.roomTypeError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="totalOccupancy">Total Occupancy:</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ totalOccupancy: event.target.value })
            }
            className="form-control"
            id="totalOccupancy"
            aria-describedby="totalOccupancyHelp"
            value={this.state.totalOccupancy}
          />
          <small id="totalOccupancyHelp" className="form-text text-muted">
            Please set the maximum number of people that can occupy the room:
          </small>
          <span style={{ color: "red" }}>{this.state.totalOccupancyError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="totalBathrooms">Total Bathrooms:</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ totalBathrooms: event.target.value })
            }
            className="form-control"
            id="totalBathrooms"
            aria-describedby="totalBathroomsHelp"
            value={this.state.totalBathrooms}
          />
          <small id="totalBathroomsHelp" className="form-text text-muted">
            Please fill the number of bathrooms that the room has:
          </small>
          <span style={{ color: "red" }}>{this.state.totalBathroomsError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="totalBedrooms">Total Bedrooms:</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ totalBedrooms: event.target.value })
            }
            className="form-control"
            id="totalBedrooms"
            aria-describedby="totalBedroomsHelp"
            value={this.state.totalBedrooms}
          />
          <small id="totalBedroomsHelp" className="form-text text-muted">
            Please fill the number of bedrooms that the room has:
          </small>
          <span style={{ color: "red" }}>{this.state.totalBedroomsError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="totalBeds">Total Beds:</label>
          <input
            type="number"
            onChange={(event) =>
              this.setState({ totalBeds: event.target.value })
            }
            className="form-control"
            id="totalBeds"
            aria-describedby="totalBedsHelp"
            value={this.state.totalBeds}
          />
          <small id="totalBedsHelp" className="form-text text-muted">
            Please fill the number of beds that the room has:
          </small>
          <span style={{ color: "red" }}>{this.state.totalBedsError}</span>
        </div>

        <h3>Does your room have</h3>

        <div className="form-group">
          <label className="w-50" htmlFor="hasTV">
            TV:
          </label>
          <input
            type="checkbox"
            onChange={(event) => this.setState({ hasTV: event.target.value })}
            className="form-control-inline w-50"
            id="hasTV"
            value={this.state.hasTV}
          />
          <span style={{ color: "red" }}>{this.state.hasTVError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasKitchen">
            Kitchen:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasKitchen: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasKitchen"
            value={this.state.hasKitchen}
          />
          <span style={{ color: "red" }}>{this.state.hasKitchenError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasLivingRoom">
            Living Room:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasLivingRoom: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasLivingRoom"
            value={this.state.hasLivingRoom}
          />
          <span style={{ color: "red" }}>{this.state.hasLivingRoomError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasAirConditioning">
            Air Conditioning:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasAirConditioning: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasAirConditioning"
            value={this.state.hasAirConditioning}
          />
          <span style={{ color: "red" }}>
            {this.state.hasAirConditioningError}
          </span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasHeating">
            Heating:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasHeating: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasHeating"
            value={this.state.hasHeating}
          />
          <span style={{ color: "red" }}>{this.state.hasHeatingError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasWifi">
            Wi Fi:
          </label>
          <input
            type="checkbox"
            onChange={(event) => this.setState({ hasWifi: event.target.value })}
            className="form-control-inline w-50"
            id="hasWifi"
            value={this.state.hasWifi}
          />
          <span style={{ color: "red" }}>{this.state.hasWifiError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasParking">
            Parking:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasParking: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasParking"
            value={this.state.hasParking}
          />
          <span style={{ color: "red" }}>{this.state.hasParkingError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="hasElevator">
            Elevator:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ hasElevator: event.target.value })
            }
            className="form-control-inline w-50"
            id="hasElevator"
            value={this.state.hasElevator}
          />
          <span style={{ color: "red" }}>{this.state.hasElevatorError}</span>
        </div>

        <h3>Do you allow</h3>

        <div className="form-group">
          <label className="w-50" htmlFor="isSmokingInsideAllowed">
            Smoking inside:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ isSmokingInsideAllowed: event.target.value })
            }
            className="form-control-inline w-50"
            id="isSmokingInsideAllowed"
            value={this.state.isSmokingInsideAllowed}
          />
          <span style={{ color: "red" }}>
            {this.state.isSmokingInsideAllowedError}
          </span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="arePetsAllowed">
            Pets:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ arePetsAllowed: event.target.value })
            }
            className="form-control-inline w-50"
            id="arePetsAllowed"
            value={this.state.arePetsAllowed}
          />
          <span style={{ color: "red" }}>{this.state.arePetsAllowedError}</span>
        </div>

        <div className="form-group">
          <label className="w-50" htmlFor="arePartiesAllowed">
            Parties:
          </label>
          <input
            type="checkbox"
            onChange={(event) =>
              this.setState({ arePartiesAllowed: event.target.value })
            }
            className="form-control-inline w-50"
            id="arePartiesAllowed"
            value={this.state.arePartiesAllowed}
          />
          <span style={{ color: "red" }}>
            {this.state.arePartiesAllowedError}
          </span>
        </div>

        <button type="submit" className="btn btn-primary">
          Submit
        </button>
      </form>
    );
  }
}

export default HostRoomForm;
