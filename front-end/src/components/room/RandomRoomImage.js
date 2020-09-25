import React from "react";

const RandomRoomImage = () => {
  return (
    <>
      <img
        className="rounded-lg"
        src="https://source.unsplash.com/1600x900/?living_room"
        alt="ROOM PICTURE"
        style={{
          position: "absolute",
          left: "0px",
          height: "100%",
          width: "90%",
        }}
      />
    </>
  );
};

export default RandomRoomImage;
