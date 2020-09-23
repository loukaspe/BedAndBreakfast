import React, { Component } from "react";
import axios from "axios";
import { API_BASE_URL, API_ROOMS_ROUTE } from "../../constants/apiConstants";
import { formValidator } from "../../services/validation/formValidator";
import SearchLocationLocalityInput from "../inputs/SearchLocationAddressInput";

class MainForm extends Component {
  constructor(props) {
    super(props);

    let currentDate = new Date();
    let dateString = currentDate.toISOString().substr(0, 10);

    this.state = {
      country: "",
      city: "",
      area: "",
      startDate: dateString,
      endDate: dateString,

      countryError: "",
      cityError: "",
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
      country: this.state.country,
      city: this.state.city,
      area: this.state.area,
      startDate: this.state.startDate,
      endDate: this.state.endDate,
    };
    axios
      .post(API_BASE_URL + API_ROOMS_ROUTE, data)
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
      countryError: "",
      cityError: "",
      areaError: "",
      startDateError: "",
      endDateError: "",
    });

    let hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.country
    );
    if (hasValidationReturnedError) {
      this.setState({ countryError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.city
    );
    if (hasValidationReturnedError) {
      this.setState({ cityError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.city
    );
    if (hasValidationReturnedError) {
      this.setState({ cityError: hasValidationReturnedError });
      isFormValid = false;
    }

    return isFormValid;
  };

  handleSubmit = async (event) => {
    event.preventDefault();
    console.log("EGINE SUBMIT");
    //TODO: call

    // const resp = await axios.get(
    //   `https://api.github.com/users/${this.state.companyName}`
    // );
    // this.props.onSubmit(resp.data);
    // this.setState({ companyName: "" });
  };

  render() {
    return (
      <form
        onSubmit={this.handleSubmit}
        className={"bg-light pl-3 pr-3 pt-1 pb-1 mt-3 mb-3"}
      >
        <div className="form-group">
          <label htmlFor="pricePerNight">Address:</label>
          <SearchLocationLocalityInput onChange={() => null} />
          <small className="form-text text-muted">
            Please set the address of the room:
          </small>
        </div>

        <div className="form-group">
          <label htmlFor="country">Country:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ country: event.target.value })}
            className="form-control"
            id="country"
            aria-describedby="countryHelp"
            value={this.state.country}
          />
          <small id="countryHelp" className="form-text text-muted">
            Please select your country from the list
          </small>
        </div>

        <div className="form-group">
          <label htmlFor="city">City:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ city: event.target.value })}
            className="form-control"
            id="city"
            aria-describedby="cityHelp"
            value={this.state.city}
          />
          <small id="cityHelp" className="form-text text-muted">
            Please select your city from the list
          </small>
        </div>

        <div className="form-group">
          <label htmlFor="area">Area:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ area: event.target.value })}
            className="form-control"
            id="area"
            aria-describedby="areaHelp"
            value={this.state.area}
          />
          <small id="areaHelp" className="form-text text-muted">
            Please select your area from the list
          </small>
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
