import React from "react";
import Layout from "../global/Layout";

import "../../scss/components/pages/registrationSuccess.scss";
import {Link} from "react-router-dom";


const RegistrationSuccess = (props) => {
    return (
        <>
            <Layout
                children={
                    <div className={"successComponent"}>
                        <div className={"Title"}>
                            <i className="checkmark">✓</i>
                        </div>
                        <h1 className={"successTitle"}>Registration Success</h1>
                        <p className={"successMessage"}>You have registered successfully to our site<br/> We wish you a
                            happy journey!</p>
                        <Link
                            type="button" className="btn btn-success"
                            role="button"
                            to="/"
                        >
                            HomePage
                        </Link>

                    </div>
                }
            />
        </>
    );
};

export default RegistrationSuccess;
