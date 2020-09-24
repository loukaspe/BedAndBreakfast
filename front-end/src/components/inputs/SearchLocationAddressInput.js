import React, { useState, useEffect, useRef } from "react";
import "../../scss/components/inputs/SearchLocationInput.scss";

let autoComplete;

const loadScript = (url, callback) => {
  let script = document.createElement("script");
  script.type = "text/javascript";

  if (script.readyState) {
    script.onreadystatechange = function () {
      if (script.readyState === "loaded" || script.readyState === "complete") {
        script.onreadystatechange = null;
        callback();
      }
    };
  } else {
    script.onload = () => callback();
  }

  script.src = url;
  document.getElementsByTagName("head")[0].appendChild(script);
};

function handleScriptLoad(
  updateQuery,
  autoCompleteRef,
  setDataFromGoogleAutocomplete
) {
  autoComplete = new window.google.maps.places.Autocomplete(
    autoCompleteRef.current,
    { types: ["address"] }
  );
  autoComplete.setFields(["address_components", "formatted_address"]);
  autoComplete.addListener("place_changed", () =>
    handlePlaceSelect(updateQuery, setDataFromGoogleAutocomplete)
  );
}

async function handlePlaceSelect(updateQuery, setDataFromGoogleAutocomplete) {
  const addressObject = autoComplete.getPlace();
  const query = addressObject.formatted_address;
  updateQuery(query);
  setDataFromGoogleAutocomplete(
    addressObject.address_components[2].long_name,
    addressObject.address_components[3].long_name,
    query
  );
}

function SearchLocationAddressInput(props) {
  const [query, setQuery] = useState("");
  const autoCompleteRef = useRef(null);

  useEffect(() => {
    loadScript(
      `https://maps.googleapis.com/maps/api/js?key=${process.env.REACT_APP_GOOGLE_API_KEY}&libraries=places`,
      () => handleScriptLoad(setQuery, autoCompleteRef, props.onChange)
    );
  }, []);

  return (
    <div className="search-location-input">
      <input
        ref={autoCompleteRef}
        onChange={(event) => setQuery(event.target.value)}
        placeholder="Enter the room's address"
        value={query}
      />
    </div>
  );
}

export default SearchLocationAddressInput;
