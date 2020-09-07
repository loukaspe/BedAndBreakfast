import React from "react";
import { BrowserRouter, Route } from "react-router-dom";
import "./App.css";
import Welcome from "./components/pages/welcome";
import Register from "./components/pages/register";

function App() {
  return (
    <div>
      <BrowserRouter>
        <div>
          <Route path="/" exact component={Welcome} />
          <Route path="/register" exact component={Register} />
        </div>
      </BrowserRouter>
    </div>
  );
}

export default App;
