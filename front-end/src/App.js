import React from "react";
import { BrowserRouter, Route } from "react-router-dom";
import "./App.css";
import Welcome from "./components/pages/welcome";
import Register from "./components/pages/register";
import HostRoom from "./components/pages/hostRoom";
import Results from "./components/pages/results";
import Room from "./components/pages/room";

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
        </div>
      </BrowserRouter>
    </div>
  );
}

export default App;
