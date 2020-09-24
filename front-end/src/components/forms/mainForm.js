import React, { Component } from "react";
import RoomService from "../../services/room/roomService";
import { formValidator } from "../../services/validation/formValidator";
import SearchLocationCityInput from "../inputs/SearchLocationCityInput";

class MainForm extends Component {
  constructor(props) {
    super(props);

    let currentDate = new Date();
    let dateString = currentDate.toISOString().substr(0, 10);

    this.state = {
      locality: "",
      area: "",
      startDate: dateString,
      endDate: dateString,

      areaError: "",
      startDateError: "",
      endDateError: "",
    };

    this.handleSubmit = this.handleSubmit.bind(this);
    this.callApi = this.callApi.bind(this);
    this.validateFields = this.validateFields.bind(this);
  }

  callApi = () => {
    const data = {
      locality: this.state.locality,
      area: this.state.area,
      startDate: this.state.startDate,
      endDate: this.state.endDate,
    };

    RoomService.searchRoomWithDataFromMainForm(data)
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
      areaError: "",
      startDateError: "",
      endDateError: "",
    });

    let hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.area
    );
    if (hasValidationReturnedError) {
      this.setState({ areaError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.locality
    );
    if (hasValidationReturnedError) {
      this.setState({ areaError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateDate(
      this.state.startDate
    );
    if (hasValidationReturnedError) {
      this.setState({ startDateError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateDate(this.state.endDate);
    if (hasValidationReturnedError) {
      this.setState({ endDateError: hasValidationReturnedError });
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
          <label>Area:</label>
          <SearchLocationCityInput
            onChange={this.setAreaAndLocalityFromGoogleAutocomplete}
          />
          <small className="form-text text-muted">
            Choose your dream destination:
          </small>
          <span style={{ color: "red" }}>{this.state.areaError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="startDate">Start Date:</label>
          <input
            type="date"
            onChange={(event) =>
              this.setState({ startDate: event.target.value })
            }
            className="form-control"
            id="startDate"
            aria-describedby="startDateHelp"
            value={this.state.startDate}
          />
          <small id="startDateHelp" className="form-text text-muted">
            Please select your starting date
          </small>
        </div>

        <div className="form-group">
          <label htmlFor="endDate">End Date:</label>
          <input
            type="date"
            onChange={(event) => this.setState({ endDate: event.target.value })}
            className="form-control"
            id="endDate"
            aria-describedby="endDateHelp"
            value={this.state.endDate}
          />
          <small id="endDateHelp" className="form-text text-muted">
            Please select your ending date
          </small>
        </div>
        <button type="submit" className="btn btn-primary">
          Submit
        </button>
      </form>
    );
  }
}

export default MainForm;
