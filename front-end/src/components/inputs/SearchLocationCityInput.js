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
  setAreaAndLocalityFromGoogleAutocomplete
) {
  autoComplete = new window.google.maps.places.Autocomplete(
    autoCompleteRef.current,
    { types: ["(cities)"] }
  );
  autoComplete.setFields(["address_components", "formatted_address"]);
  autoComplete.addListener("place_changed", () =>
    handlePlaceSelect(updateQuery, setAreaAndLocalityFromGoogleAutocomplete)
  );
}

async function handlePlaceSelect(
  updateQuery,
  setAreaAndLocalityFromGoogleAutocomplete
) {
  const cityObject = autoComplete.getPlace();
  const query = cityObject.formatted_address;
  updateQuery(query);
  setAreaAndLocalityFromGoogleAutocomplete(
    cityObject.address_components[0].long_name,
    cityObject.address_components[1].long_name
  );
}

function SearchLocationCityInput(props) {
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
        placeholder="Where do you want to go"
        value={query}
      />
    </div>
  );
}

export default SearchLocationCityInput;
