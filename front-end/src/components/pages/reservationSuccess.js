import React from "react";
import Layout from "../global/Layout";

import "../../scss/components/pages/reservationSuccess.scss";
import {Link} from "react-router-dom";


const ReservationSuccess = (props) => {
    return (
        <>
            <Layout
                children={
                    <div className={"successComponent"}>
                        <div className={"Title"}>
                            <i className="checkmark">✓</i>
                        </div>
                        <h1 className={"successTitle"}>Reservation Success</h1>
                        <p className={"successMessage"}>You have made a new reservation successfully <br/> We wish you a
                            safe and sound journey!</p>
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

export default ReservationSuccess;
