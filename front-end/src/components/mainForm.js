import React, { Component } from "react";

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
    };

    this.handleSubmit = this.handleSubmit.bind(this);
  }

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
