import React, { Component } from "react";
import Authenticator from "../../services/user/authenticator";
import {
  BOTH_ROLE,
  GUEST_ROLE,
  HOST_ROLE,
} from "../../constants/enumsConstants";
import { formValidator } from "../../services/validation/formValidator";
import {withRouter} from "react-router-dom";

class RegisterForm extends Component {
  constructor(props) {
    super(props);

    this.state = {
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
      firstName: "",
      lastName: "",
      role: "guest",
      phone: "",

      usernameError: "",
      emailError: "",
      passwordError: "",
      confirmPasswordError: "",
      firstNameError: "",
      lastNameError: "",
      roleError: "",
      phoneError: "",
    };

    this.handleSubmit = this.handleSubmit.bind(this);
    this.callApi = this.callApi.bind(this);
    this.validateFields = this.validateFields.bind(this);
  }

  callApi = () => {
    const data = {
      username: this.state.username,
      firstName: this.state.firstName,
      lastName: this.state.lastName,
      role: this.state.role,
      phone: this.state.phone,
      email: this.state.email,
      password: this.state.password,
    };
    let history = this.props.history;

    Authenticator.register(data).then(function (response) {
      history.push({
        pathname: '/registrationSuccess',
      });
    })
    .catch(function (error) {
      console.log(error);
      //TODO: FailPage
    });
  };

  validateFields = () => {
    let isFormValid = true;

    this.setState({
      roleError: "",
      phoneError: "",
      confirmPasswordError: "",
      passwordError: "",
      lastNameError: "",
      firstNameError: "",
      emailError: "",
      usernameError: "",
    });

    let hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.username
    );
    if (hasValidationReturnedError) {
      this.setState({ usernameError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateEmail(this.state.email);
    if (hasValidationReturnedError) {
      this.setState({ emailError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.firstName
    );
    if (hasValidationReturnedError) {
      this.setState({ firstNameError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.lastName
    );
    if (hasValidationReturnedError) {
      this.setState({ lastNameError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validatePassword(
      this.state.password
    );
    if (hasValidationReturnedError) {
      this.setState({ passwordError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validatePasswordConfirmation(
      this.state.password,
      this.state.confirmPassword
    );
    if (hasValidationReturnedError) {
      this.setState({ confirmPasswordError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validatePhone(this.state.phone);
    if (hasValidationReturnedError) {
      this.setState({ phoneError: hasValidationReturnedError });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validateRole(this.state.role);
    if (hasValidationReturnedError) {
      this.setState({ roleError: hasValidationReturnedError });
      isFormValid = false;
    }

    return isFormValid;
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
          <label htmlFor="username">Username:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ username: event.target.value })
            }
            className="form-control"
            id="username"
            aria-describedby="usernameHelp"
            value={this.state.username}
          />
          <small id="usernameHelp" className="form-text text-muted">
            Please enter your username
          </small>
          <span style={{ color: "red" }}>{this.state.usernameError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="email">Email:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ email: event.target.value })}
            className="form-control"
            id="email"
            aria-describedby="emailHelp"
            value={this.state.email}
          />
          <small id="emailHelp" className="form-text text-muted">
            Please enter your email
          </small>

          <span style={{ color: "red" }}>{this.state.emailError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="password">Password:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ password: event.target.value })
            }
            className="form-control"
            id="password"
            aria-describedby="passwordHelp"
            value={this.state.password}
          />
          <small id="passwordHelp" className="form-text text-muted">
            Please enter your password
          </small>
          <span style={{ color: "red" }}>{this.state.passwordError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="password">Confirm Password:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ confirmPassword: event.target.value })
            }
            className="form-control"
            id="confirmPassword"
            aria-describedby="confirmPasswordHelp"
            value={this.state.confirmPassword}
          />
          <small id="confirmPasswordHelp" className="form-text text-muted">
            Please confirm your password
          </small>
          <span style={{ color: "red" }}>
            {this.state.confirmPasswordError}
          </span>
        </div>

        <div className="form-group">
          <label htmlFor="firstName">First Name:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ firstName: event.target.value })
            }
            className="form-control"
            id="firstName"
            aria-describedby="firstNameHelp"
            value={this.state.firstName}
          />
          <small id="firstNameHelp" className="form-text text-muted">
            Please enter your first name
          </small>
          <span style={{ color: "red" }}>{this.state.firstNameError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="lastName">Last Name:</label>
          <input
            type="text"
            onChange={(event) =>
              this.setState({ lastName: event.target.value })
            }
            className="form-control"
            id="lastName"
            aria-describedby="lastNameHelp"
            value={this.state.lastName}
          />
          <small id="lastNameHelp" className="form-text text-muted">
            Please enter your last name
          </small>
          <span style={{ color: "red" }}>{this.state.lastNameError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="phone">Phone Number:</label>
          <input
            type="text"
            onChange={(event) => this.setState({ phone: event.target.value })}
            className="form-control"
            id="phone"
            aria-describedby="phoneHelp"
            value={this.state.phone}
          />
          <small id="phoneHelp" className="form-text text-muted">
            Please enter your phone number
          </small>
          <span style={{ color: "red" }}>{this.state.phoneError}</span>
        </div>

        <div className="form-group">
          <label htmlFor="role">I want to register as:</label>

          <select
            className="form-control"
            id="role"
            aria-describedby="roleHelp"
            value={this.state.role}
            onChange={(event) => this.setState({ role: event.target.value })}
          >
            <option value={HOST_ROLE}>Host</option>
            <option value={GUEST_ROLE}>Guest</option>
            <option value={BOTH_ROLE}>Both</option>
          </select>
          <small id="roleHelp" className="form-text text-muted">
            Please select your role
          </small>
          <span style={{ color: "red" }}>{this.state.roleError}</span>
        </div>

        <button type="submit" className="btn btn-primary">
          Submit
        </button>
      </form>
    );
  }
}

export default withRouter(RegisterForm);