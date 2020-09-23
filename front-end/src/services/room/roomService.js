import axios from "axios";
import { API_BASE_URL, API_ROOMS_ROUTE } from "../../constants/apiConstants";
import Authenticator from "../user/authenticator";

class RoomService {
  registerRoom(data) {
    data.userId = Authenticator.getCurrentUserId();
    console.log(JSON.stringify(data));
    return axios.post(API_BASE_URL + API_ROOMS_ROUTE, data, {
      headers: Authenticator.getCurrentUserToken(),
    });
  }
}

export default new RoomService();
