import { defineRule, configure } from "vee-validate";
configure({
  validateOnBlur: true,
  validateOnChange: true,
  validateOnInput: true,
});

defineRule("required", (value, { field }) => {
  return !(!value || !value.length);
});

defineRule("email", (value) => {
  const regexEmail =
    /^(?=.{1,64}@)[a-zA-Z0-9!#$%&'*+\-/=?^_`{|}~]+(?:\.[a-zA-Z0-9!#$%&'*+\-/=?^_`{|}~]+)*@(?:(?!-)[a-zA-Z0-9\-]{1,63}(?<!-)\.)+[a-zA-Z]{2,63}$/;
  return regexEmail.test(value);
});

defineRule("min", (value, [limit]) => {
  return value.length >= limit;
});

defineRule("max", (value, [limit]) => {
  return value.length <= limit;
});

defineRule("minNumber", (value, [limit]) => {
  return +value >= limit;
});

defineRule("maxNumber", (value, [limit]) => {
  return +value <= limit;
});

defineRule("minWordsThree", (value) => {
  const regexMinWords = /^([a-z0-9]*[a-z]){3}[a-z0-9]*$/i;
  if (!regexMinWords.test(value)) {
    return;
  }
  return true;
});

defineRule("phone", (value) => {
  const regexPhoneNumber = /^\+(?:[0-9] ?){6,14}[0-9]$/;
  return regexPhoneNumber.test(value);
});

defineRule("confirmed", (value, { target }) => {
  return value === target;
});

defineRule("upperAndLower", (value) => {
  const regex = /^(?=.*?[A-Z])(?=.*?[a-z]).+$/;
  return regex.test(value);
});
