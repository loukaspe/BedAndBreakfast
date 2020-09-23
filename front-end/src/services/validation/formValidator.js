import validator from "validator";
import {
  BOTH_ROLE,
  GUEST_ROLE,
  HOST_ROLE,
  APPARTMENT_ROOM_TYPE,
  CHALET_ROOM_TYPE,
  HOTEL_ROOM_TYPE,
  GUEST_ROOM_ROOM_TYPE,
  HOUSE_ROOM_TYPE,
  MAISONETTE_ROOM_TYPE,
} from "../../constants/enumsConstants";

class FormValidator {
  validateEmail(email) {
    if (validator.isEmpty(email)) {
      return "Email is required";
    } else if (!validator.isEmail(email)) {
      return "Invalid Email";
    }

    return false;
  }

  validateNotEmptyField(field) {
    if (validator.isEmpty(field)) {
      return "This field is required";
    }

    return false;
  }

  validateNumberNotZero(field) {
    return field !== 0 && field > 0 ? false : "Value cannot be zero";
  }

  validateDate(date) {
    if (validator.isEmpty(date)) {
      return "This field is required";
    }

    let dateAsObject = new Date(date);

    if (!validator.isDate(dateAsObject)) {
      return "Please select a date";
    }
  }

  validateRole(role) {
    if (validator.isEmpty(role)) {
      return "Role is required";
    }

    if (role !== BOTH_ROLE && role !== GUEST_ROLE && role !== HOST_ROLE) {
      return "Not valid role option";
    }

    return false;
  }

  validateRoomType(roomType) {
    if (validator.isEmpty(roomType)) {
      return "Room Type is required";
    }

    if (
      roomType !== APPARTMENT_ROOM_TYPE &&
      roomType !== CHALET_ROOM_TYPE &&
      roomType !== HOTEL_ROOM_TYPE &&
      roomType !== GUEST_ROOM_ROOM_TYPE &&
      roomType !== HOUSE_ROOM_TYPE &&
      roomType !== MAISONETTE_ROOM_TYPE
    ) {
      return "Not valid room type option";
    }

    return false;
  }

  validatePhone(phone) {
    if (validator.isEmpty(phone)) {
      return "Phone is required";
    }

    if (!validator.isMobilePhone(phone)) {
      return "Not valid phone number";
    }

    return false;
  }

  validatePassword(password) {
    if (validator.isEmpty(password)) {
      return "Password is required";
    } else if (!validator.isLength(password, { min: 6 })) {
      return "Password should be minimum 6 characters";
    }

    return false;
  }

  validatePasswordConfirmation(password, confirmedPassword) {
    if (validator.isEmpty(password)) {
      return "Password is required";
    } else if (validator.isEmpty(confirmedPassword)) {
      return "Password confirmation is required";
    } else if (password !== confirmedPassword) {
      return "Passwords do not match";
    }

    return false;
  }
}

const formValidator = new FormValidator();

export { formValidator };
