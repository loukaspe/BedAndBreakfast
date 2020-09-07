import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faFacebookSquare,
  faTwitterSquare,
  faInstagramSquare,
  faTiktok,
  faLinkedin,
  faSnapchatSquare,
} from "@fortawesome/free-brands-svg-icons";

const Footer = (props) => {
  return (
    <>
      <footer className="page-footer font-small blue pt-4">
        <div className="container-fluid text-center text-md-left">
          <div className="row">
            <div className="col-md-4 mt-md-0 mt-3">
              <h5 className="text-uppercase">AerasKkP</h5>
              <p>
                Every similarity to a famous hosting site is accidental. We
                intented to copy it but we are too stupid to do it, thus
                accidental
              </p>
            </div>

            <hr class="clearfix w-100 d-md-none pb-3" />

            <div class="col-md-4 mb-md-0 mb-3">
              <h5 class="text-uppercase">Useful</h5>

              <ul class="list-unstyled">
                <li>
                  <a href="#!">Link 1</a>
                </li>
                <li>
                  <a href="#!">Link 2</a>
                </li>
                <li>
                  <a href="#!">Link 3</a>
                </li>
                <li>
                  <a href="#!">Link 4</a>
                </li>
              </ul>
            </div>

            <div className="col-md-4 mb-md-0 mb-3">
              <h5 className="text-uppercase">Social Media</h5>
              <div className="mb-5 flex-center">
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faFacebookSquare} size={"3x"} />
                </a>
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faTwitterSquare} size={"3x"} />
                </a>
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faInstagramSquare} size={"3x"} />
                </a>
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faTiktok} size={"3x"} />
                </a>
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faLinkedin} size={"3x"} />
                </a>
                <a className="mr-md-4 mr-3">
                  <FontAwesomeIcon icon={faSnapchatSquare} size={"3x"} />
                </a>
              </div>
            </div>
          </div>
        </div>

        <div className={"footer-copyright text-center py-3"}>
          © 2020 Copyright: Peteinaris & Polychronopoulos
        </div>
      </footer>
    </>
  );
};

Footer.propTypes = {};

export default Footer;
