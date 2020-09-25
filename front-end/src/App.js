import React from "react";
import { BrowserRouter, Route } from "react-router-dom";
import "./App.css";
import Welcome from "./components/pages/welcome";
import Register from "./components/pages/register";
import HostRoom from "./components/pages/hostRoom";
import Results from "./components/pages/results";
import Room from "./components/pages/room";
import RegistrationSuccess from "./components/pages/registrationSuccess";
import ReservationSuccess from "./components/pages/reservationSuccess";

function App() {
  return (
    <div>
      <BrowserRouter>
        <div>
          <Route path="/" exact component={Welcome} />
          <Route path="/register" exact component={Register} />
          <Route path="/hostRoom" exact component={HostRoom} />
          <Route path="/results" exact component={Results} />
          <Route path="/room" exact component={Room} />
          <Route path="/registrationSuccess" exact component={RegistrationSuccess} />
          <Route path="/reservationSuccess" exact component={ReservationSuccess} />

        </div>
      </BrowserRouter>
    </div>
  );
}

export default App;
