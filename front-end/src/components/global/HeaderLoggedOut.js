import React from "react";
import { Link } from "react-router-dom";
import LoginForm from "../forms/loginForm";

const HeaderLoggedOut = (props) => {
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
              <a className="nav-link" href="#">
                Link 1
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="#">
                Link 2
              </a>
            </li>
          </ul>
          <LoginForm />
          <Link to="/register">Register</Link>
        </div>
      </nav>
    </div>
  );
};

HeaderLoggedOut.propTypes = {};

export default HeaderLoggedOut;
