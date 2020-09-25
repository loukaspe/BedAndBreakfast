import React from "react";
import Authenticator from "../../services/user/authenticator";
import { withRouter } from "react-router-dom";

const HeaderLoggedIn = (props) => {
  const logout = () => {
    let history = props.history;
    Authenticator.logout();
    history.push("/");
  };

  return (
    <div>
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <a className="navbar-brand" href="/">
          AERAS KKP
        </a>

        <div className="collapse navbar-collapse" id="navbarTogglerDemo03">
          <ul className="navbar-nav mr-auto mt-2 mt-lg-0">
            <li className="nav-item active">
              <a className="nav-link" href="#">
                Home <span className="sr-only">(current)</span>
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="/profile">
                Profile
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="#">
                In
              </a>
            </li>
          </ul>
          <button onClick={logout}>Logout</button>
        </div>
      </nav>
    </div>
  );
};

HeaderLoggedIn.propTypes = {};

export default withRouter(HeaderLoggedIn);
