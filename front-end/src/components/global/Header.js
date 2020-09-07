import React from "react";
import { Link } from "react-router-dom";
import Register from "../pages/register";

const Header = (props) => {
  return (
    <div>
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <a className="navbar-brand" href="#">
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
          <form className="form-inline my-2 my-lg-0 mr-5">
            <input
              className="form-control mr-sm-2"
              type="text"
              placeholder="username"
              aria-label="username"
            />
            <input
              className="form-control mr-sm-2"
              type="text"
              placeholder="password"
              aria-label="password"
            />
            <button
              className="btn btn-outline-success my-2 my-sm-0"
              type="submit"
            >
              Login
            </button>
          </form>
          <Link to="/register">Register</Link>
        </div>
      </nav>
    </div>
  );
};

Header.propTypes = {};

export default Header;
