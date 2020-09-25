import React, { Component } from "react";
import Authenticator from "../../services/user/authenticator";
import { formValidator } from "../../services/validation/formValidator";
import { withRouter } from "react-router-dom";

class LoginForm extends Component {
  constructor(props) {
    super(props);

    this.state = {
      username: "",
      password: "",

      usernameError: "",
      passwordError: "",
    };

    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.callApi = this.callApi.bind(this);
    this.validateFields = this.validateFields.bind(this);
  }

  callApi = () => {
    const data = {
      username: this.state.username,
      password: this.state.password,
    };

    Authenticator.login(data).catch(function (error) {
      console.log(error);
      this.setState({
        loginError: "Invalid Credentials",
      });
    });

    this.props.history.push("/");
  };

  validateFields = () => {
    let isFormValid = true;

    this.setState({
      loginError: "",
    });

    let hasValidationReturnedError = formValidator.validateNotEmptyField(
      this.state.username
    );
    if (hasValidationReturnedError) {
      this.setState({ loginError: "Invalid Credentials" });
      isFormValid = false;
    }

    hasValidationReturnedError = formValidator.validatePassword(
      this.state.password
    );
    if (hasValidationReturnedError) {
      this.setState({ loginError: "Invalid Credentials" });
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
        className="form-inline my-2 my-lg-0 mr-5"
      >
        <input
          className="form-control mr-sm-2"
          type="text"
          placeholder="username"
          aria-label="username"
          onChange={(event) => this.setState({ username: event.target.value })}
        />
        <input
          className="form-control mr-sm-2"
          type="text"
          placeholder="password"
          aria-label="password"
          onChange={(event) => this.setState({ password: event.target.value })}
        />
        <button className="btn btn-outline-success my-2 my-sm-0" type="submit">
          Login
        </button>
        <div className="p-2">
          <span style={{ color: "red" }}>{this.state.loginError}</span>
        </div>
      </form>
    );
  }
}

export default withRouter(LoginForm);
