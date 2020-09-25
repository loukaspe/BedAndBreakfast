import React from "react";
import Authenticator from "../../services/user/authenticator";
import HeaderLoggedIn from "./HeaderLoggedIn";
import HeaderLoggedOut from "./HeaderLoggedOut";

const Header = (props) => {
  return Authenticator.isLoggedIn() ? <HeaderLoggedIn /> : <HeaderLoggedOut />;
};

Header.propTypes = {};

export default Header;
